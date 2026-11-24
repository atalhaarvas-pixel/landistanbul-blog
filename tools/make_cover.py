#!/usr/bin/env python3
"""
Land Istanbul cover generator.

Usage:
    python3 tools/make_cover.py posts/2026-11-24-some-post.json

Draws an original Istanbul skyline illustration for the post (seeded by its group slug, themed by
its segment), then writes:
    images/<group>-hero.jpg          1600x900, no text  (hero + blog cards)
    images/<group>-og-<lang>.jpg     1200x630, title in that language (social sharing)
and records the paths in the post JSON ("images" and "og_images").
"""
import json
import math
import random
import sys
from pathlib import Path

from PIL import Image, ImageDraw, ImageFilter, ImageFont, features

ROOT = Path(__file__).resolve().parent.parent
ROBOTO = "/usr/share/fonts/truetype/google-fonts/ofl/roboto/Roboto[wdth,wght].ttf"
DEJAVU_BOLD = "/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf"
DEJAVU = "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf"
RED = (231, 0, 0)
DARK_RED = (197, 0, 0)

PALETTES = {
    "sunset": dict(top=(38, 10, 22), bottom=(236, 104, 62), sun=(255, 214, 140), far=(122, 62, 78), near=(22, 10, 18), water=(58, 22, 34), glow=(255, 150, 90)),
    "dusk": dict(top=(20, 24, 58), bottom=(214, 110, 96), sun=(255, 206, 150), far=(92, 74, 112), near=(16, 14, 30), water=(30, 28, 56), glow=(240, 140, 120)),
    "night": dict(top=(6, 10, 26), bottom=(38, 54, 96), sun=(244, 240, 222), far=(40, 52, 86), near=(5, 7, 14), water=(10, 16, 34), glow=(170, 190, 255)),
    "dawn": dict(top=(84, 108, 150), bottom=(246, 196, 160), sun=(255, 236, 200), far=(128, 128, 154), near=(34, 36, 56), water=(70, 80, 110), glow=(255, 220, 180)),
    "golden": dict(top=(60, 40, 70), bottom=(250, 178, 90), sun=(255, 236, 170), far=(150, 98, 92), near=(30, 18, 24), water=(76, 46, 50), glow=(255, 190, 110)),
}


def lerp(a, b, t):
    return tuple(int(a[i] + (b[i] - a[i]) * t) for i in range(3))


def font(path, size, variation=None):
    f = ImageFont.truetype(path, size, layout_engine=ImageFont.Layout.RAQM if features.check("raqm") else ImageFont.Layout.BASIC)
    if variation:
        try:
            f.set_variation_by_name(variation)
        except Exception:
            pass
    return f


# ───────────────────────── skyline pieces ─────────────────────────

def draw_minaret(d, x, base, h, w, color):
    d.rectangle([x - w / 2, base - h, x + w / 2, base], fill=color)
    for frac in (0.55, 0.78):
        y = base - h * frac
        d.rectangle([x - w * 0.95, y - w * 0.35, x + w * 0.95, y], fill=color)
    d.polygon([(x - w * 0.62, base - h), (x + w * 0.62, base - h), (x, base - h - w * 4.2)], fill=color)


def draw_mosque(d, cx, base, s, color, rng, minarets=None):
    # main hall
    d.rectangle([cx - 1.25 * s, base - 0.55 * s, cx + 1.25 * s, base], fill=color)
    # half domes and small domes
    for dx in (-0.85, 0.85):
        r = 0.42 * s
        d.pieslice([cx + dx * s - r, base - 0.55 * s - r, cx + dx * s + r, base - 0.55 * s + r], 180, 360, fill=color)
    for dx in (-1.15, 1.15):
        r = 0.2 * s
        d.pieslice([cx + dx * s - r, base - 0.55 * s - r, cx + dx * s + r, base - 0.55 * s + r], 180, 360, fill=color)
    # drum + main dome + finial
    d.rectangle([cx - 0.62 * s, base - 0.9 * s, cx + 0.62 * s, base - 0.5 * s], fill=color)
    r = 0.66 * s
    d.pieslice([cx - r, base - 0.9 * s - r, cx + r, base - 0.9 * s + r], 180, 360, fill=color)
    d.rectangle([cx - 0.02 * s, base - 1.75 * s, cx + 0.02 * s, base - 1.5 * s], fill=color)
    n = minarets if minarets is not None else rng.choice([2, 4, 4, 6])
    spots = {2: [-1.55, 1.55], 4: [-1.9, -1.45, 1.45, 1.9], 6: [-2.3, -1.85, -1.45, 1.45, 1.85, 2.3]}[n]
    for i, dx in enumerate(spots):
        h = s * (2.3 if abs(dx) < 1.7 else 2.0) * rng.uniform(0.95, 1.05)
        draw_minaret(d, cx + dx * s, base, h, s * 0.07, color)


def draw_galata(d, cx, base, s, color):
    d.rectangle([cx - 0.28 * s, base - 1.9 * s, cx + 0.28 * s, base], fill=color)
    d.rectangle([cx - 0.34 * s, base - 2.0 * s, cx + 0.34 * s, base - 1.88 * s], fill=color)
    d.polygon([(cx - 0.34 * s, base - 2.0 * s), (cx + 0.34 * s, base - 2.0 * s), (cx, base - 2.75 * s)], fill=color)


def draw_tower_block(d, x, base, w, h, color, window, rng, lit):
    d.rectangle([x, base - h, x + w, base], fill=color)
    if rng.random() < 0.35:
        d.polygon([(x, base - h), (x + w, base - h), (x + w / 2, base - h - w * 0.5)], fill=color)
    if lit:
        step_x, step_y = max(5, w / 6), 9
        yy = base - h + 8
        while yy < base - 6:
            xx = x + 4
            while xx < x + w - 5:
                if rng.random() < 0.28:
                    d.rectangle([xx, yy, xx + 2, yy + 3], fill=window)
                xx += step_x
            yy += step_y


def draw_bridge(d, x0, x1, deck_y, tower_h, color, width_px):
    t1, t2 = x0 + (x1 - x0) * 0.22, x0 + (x1 - x0) * 0.78
    for tx in (t1, t2):
        d.rectangle([tx - 5, deck_y - tower_h, tx + 5, deck_y + 30], fill=color)
        d.rectangle([tx - 9, deck_y - tower_h * 0.55, tx + 9, deck_y - tower_h * 0.5], fill=color)
    d.rectangle([x0, deck_y, x1, deck_y + 7], fill=color)
    pts = []
    for i in range(41):
        t = i / 40
        x = t1 + (t2 - t1) * t
        y = deck_y - tower_h + (tower_h - 18) * (1 - (2 * t - 1) ** 2)
        pts.append((x, y))
    d.line(pts, fill=color, width=width_px)
    d.line([(x0, deck_y - 10), (t1, deck_y - tower_h)], fill=color, width=width_px)
    d.line([(t2, deck_y - tower_h), (x1, deck_y - 10)], fill=color, width=width_px)
    for i in range(1, 40, 2):
        x, y = pts[i]
        d.line([(x, y), (x, deck_y)], fill=color, width=1)


def draw_gull(d, x, y, s, color):
    d.line([(x - s, y - s * 0.3), (x - s * 0.4, y - s * 0.55), (x, y)], fill=color, width=2)
    d.line([(x, y), (x + s * 0.4, y - s * 0.55), (x + s, y - s * 0.3)], fill=color, width=2)


def draw_ferry(d, x, y, s, color, light):
    d.polygon([(x - 2.2 * s, y), (x + 2.2 * s, y), (x + 1.8 * s, y + 0.55 * s), (x - 1.9 * s, y + 0.55 * s)], fill=color)
    d.rectangle([x - 1.4 * s, y - 0.6 * s, x + 1.2 * s, y], fill=color)
    d.rectangle([x - 0.2 * s, y - 1.2 * s, x + 0.25 * s, y - 0.6 * s], fill=color)
    for i in range(6):
        xx = x - 1.2 * s + i * 0.4 * s
        d.rectangle([xx, y - 0.42 * s, xx + 0.15 * s, y - 0.25 * s], fill=light)


# ───────────────────────── scene ─────────────────────────

def render_scene(group, segment, W=1600, H=900):
    rng = random.Random(group)
    pal_name = rng.choice(list(PALETTES))
    if segment == "citizenship" and rng.random() < 0.5:
        pal_name = "sunset"
    p = PALETTES[pal_name]
    night = pal_name in ("night", "dusk")
    horizon = int(H * rng.uniform(0.6, 0.66))

    img = Image.new("RGB", (W, H))
    d = ImageDraw.Draw(img)
    for y in range(horizon):
        d.line([(0, y), (W, y)], fill=lerp(p["top"], p["bottom"], (y / horizon) ** 1.15))

    if pal_name == "night":
        for _ in range(170):
            x, y = rng.randrange(W), rng.randrange(int(horizon * 0.7))
            b = rng.randint(150, 255)
            d.point((x, y), fill=(b, b, b))

    # sun / moon with glow
    sx = int(W * rng.uniform(0.18, 0.82))
    sy = int(horizon * rng.uniform(0.35, 0.72))
    sr = int(H * (0.045 if pal_name == "night" else 0.07))
    glow = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    gd = ImageDraw.Draw(glow)
    for k in range(6, 0, -1):
        rr = sr * (1 + k * 0.9)
        gd.ellipse([sx - rr, sy - rr, sx + rr, sy + rr], fill=p["glow"] + (int(18 + 6 * (6 - k)),))
    glow = glow.filter(ImageFilter.GaussianBlur(radius=sr * 0.9))
    img.paste(glow, (0, 0), glow)
    d = ImageDraw.Draw(img)
    d.ellipse([sx - sr, sy - sr, sx + sr, sy + sr], fill=p["sun"])

    # soft clouds
    clouds = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    cd = ImageDraw.Draw(clouds)
    for _ in range(rng.randint(3, 6)):
        cx, cy = rng.randrange(W), int(horizon * rng.uniform(0.12, 0.6))
        for _ in range(5):
            w, h = rng.randint(120, 320), rng.randint(18, 40)
            ox, oy = rng.randint(-120, 120), rng.randint(-14, 14)
            cd.ellipse([cx + ox - w, cy + oy - h, cx + ox + w, cy + oy + h], fill=p["sun"] + (rng.randint(14, 30),))
    clouds = clouds.filter(ImageFilter.GaussianBlur(radius=16))
    img.paste(clouds, (0, 0), clouds)

    # far shore (Asian side): gentle hills with tiny buildings
    far = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    fd = ImageDraw.Draw(far)
    base_far = horizon - int(H * 0.035)
    pts = [(0, horizon)]
    for x in range(0, W + 40, 40):
        pts.append((x, base_far - 18 * math.sin(x / 260 + rng.random()) - rng.randint(0, 10)))
    pts.append((W, horizon))
    fd.polygon(pts, fill=p["far"] + (255,))
    x = 0
    while x < W:
        w = rng.randint(10, 26)
        h = rng.randint(6, 34)
        fd.rectangle([x, base_far - h, x + w, horizon], fill=p["far"] + (255,))
        x += w + rng.randint(2, 22)
    img.paste(far, (0, 0), far)

    # main skyline layer (drawn on its own layer for the reflection)
    sky = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    sd = ImageDraw.Draw(sky)
    near = p["near"] + (255,)
    window = (255, 214, 120, 255)
    base = horizon

    # ground strip
    sd.rectangle([0, base - 10, W, base], fill=near)

    layout = []
    # choose landmarks depending on segment
    if segment in ("apartment", "sell"):
        layout = ["towers", "mosque_s", "galata", "towers", "mosque_l"]
    elif segment == "land":
        layout = ["mosque_l", "towers_low", "galata"]
    elif segment == "citizenship":
        layout = ["mosque_l", "galata", "mosque_s", "towers"]
    else:
        layout = ["mosque_l", "towers", "galata", "mosque_s"]
    rng.shuffle(layout)

    slots = len(layout)
    margin = W * 0.06
    span = (W - 2 * margin) / slots
    bridge_side = rng.choice(["left", "right", None])
    for i, item in enumerate(layout):
        cx = margin + span * (i + 0.5) + rng.uniform(-span * 0.12, span * 0.12)
        if item == "mosque_l":
            draw_mosque(sd, cx, base, H * 0.105, near, rng)
        elif item == "mosque_s":
            draw_mosque(sd, cx, base, H * 0.072, near, rng, minarets=2)
        elif item == "galata":
            draw_galata(sd, cx, base, H * 0.075, near)
        elif item in ("towers", "towers_low"):
            low = item == "towers_low"
            x = cx - span * 0.38
            while x < cx + span * 0.38:
                w = rng.randint(26, 52)
                h = rng.randint(40, 110) if low else rng.randint(70, 250)
                draw_tower_block(sd, x, base, w, h, near, window, rng, night)
                x += w + rng.randint(2, 10)
    # low houses between landmarks
    x = 0
    while x < W:
        w = rng.randint(14, 34)
        h = rng.randint(10, 30)
        sd.rectangle([x, base - h, x + w, base], fill=near)
        if rng.random() < 0.3:
            sd.polygon([(x, base - h), (x + w, base - h), (x + w / 2, base - h - 8)], fill=near)
        if night and rng.random() < 0.4:
            sd.rectangle([x + 4, base - h + 5, x + 7, base - h + 8], fill=window)
        x += w + rng.randint(0, 8)
    img.paste(sky, (0, 0), sky)

    # water / land
    d = ImageDraw.Draw(img)
    if segment == "land":
        # foreground fields with parcel lines in perspective
        top_c = lerp(p["far"], (78, 98, 54), 0.55)
        bot_c = (40, 58, 30) if not night else (18, 26, 18)
        for y in range(base, H):
            d.line([(0, y), (W, y)], fill=lerp(top_c, bot_c, (y - base) / (H - base)))
        vp = (W * rng.uniform(0.35, 0.65), base - 40)
        line_c = lerp(bot_c, (230, 220, 170), 0.45)
        for k in range(-12, 13):
            x_bottom = W / 2 + k * W / 9
            d.line([(vp[0] + (x_bottom - vp[0]) * 0.03, base + 4), (x_bottom, H)], fill=line_c, width=2)
        y = base + 8
        gap = 6
        while y < H:
            d.line([(0, y), (W, y)], fill=line_c, width=1 if y < base + 80 else 2)
            gap *= 1.45
            y += gap
        # survey pegs with red flags
        for _ in range(rng.randint(3, 5)):
            px, py = rng.randint(int(W * 0.1), int(W * 0.9)), rng.randint(base + 120, H - 60)
            ph = (py - base) * 0.35
            d.line([(px, py), (px, py - ph)], fill=(240, 236, 220), width=max(2, int(ph / 18)))
            d.polygon([(px, py - ph), (px + ph * 0.45, py - ph * 0.86), (px, py - ph * 0.72)], fill=RED)
    else:
        for y in range(base, H):
            t = (y - base) / (H - base)
            d.line([(0, y), (W, y)], fill=lerp(lerp(p["bottom"], p["water"], 0.55), p["water"], t ** 0.7))
        # reflection of the skyline
        refl = sky.transpose(Image.FLIP_TOP_BOTTOM).crop((0, H - base, W, H - base + (H - base)))
        refl = refl.filter(ImageFilter.GaussianBlur(2))
        alpha = refl.split()[3].point(lambda a: int(a * 0.38))
        refl.putalpha(alpha)
        rimg = Image.new("RGBA", refl.size, (0, 0, 0, 0))
        for yy in range(refl.size[1]):
            shift = int(6 * math.sin(yy / 3.0) * (yy / refl.size[1] + 0.2))
            row = refl.crop((0, yy, W, yy + 1))
            rimg.paste(row, (shift, yy))
        img.paste(rimg, (0, base), rimg)
        d = ImageDraw.Draw(img)
        # sun path on water
        for k in range(26):
            yy = base + 6 + k * (H - base) / 28
            ww = (20 + k * 9) * rng.uniform(0.6, 1.2)
            col = lerp(p["sun"], p["water"], min(1, k / 26 + 0.15))
            d.line([(sx - ww, yy), (sx + ww, yy)], fill=col, width=2)
        if bridge_side:
            x0, x1 = (W * -0.05, W * 0.38) if bridge_side == "left" else (W * 0.62, W * 1.05)
            bridge = Image.new("RGBA", (W, H), (0, 0, 0, 0))
            draw_bridge(ImageDraw.Draw(bridge), x0, x1, base + 22, H * 0.2, p["near"] + (255,), 3)
            img.paste(bridge, (0, 0), bridge)
        d = ImageDraw.Draw(img)
        for _ in range(rng.randint(1, 2)):
            fx = rng.randint(int(W * 0.1), int(W * 0.9))
            fy = rng.randint(base + 60, H - 80)
            draw_ferry(d, fx, fy, H * 0.018 * (1 + (fy - base) / (H - base)), p["near"], window if night else lerp(p["sun"], p["near"], 0.3))

    # seagulls
    gull_c = p["near"] if pal_name not in ("night",) else (200, 205, 220)
    for _ in range(rng.randint(3, 7)):
        draw_gull(d, rng.randint(int(W * 0.05), int(W * 0.95)), rng.randint(int(H * 0.1), int(horizon * 0.55)), rng.randint(8, 18), gull_c)

    # brand accent line + slight vignette
    vig = Image.new("L", (W, H), 0)
    vd = ImageDraw.Draw(vig)
    vd.ellipse([-W * 0.2, -H * 0.3, W * 1.2, H * 1.3], fill=255)
    vig = vig.filter(ImageFilter.GaussianBlur(120))
    dark = Image.new("RGB", (W, H), (0, 0, 0))
    img = Image.composite(img, dark, vig.point(lambda v: int(150 + v * 105 / 255)))
    ImageDraw.Draw(img).rectangle([0, H - 8, W, H], fill=RED)
    return img


# ───────────────────────── social image with title ─────────────────────────

CATEGORY = {
    "en": {"sell": "SELLING PROPERTY", "citizenship": "TURKISH CITIZENSHIP", "apartment": "BUYING PROPERTY", "land": "LAND INVESTMENT", "general": "MARKET INSIGHTS"},
    "ar": {"sell": "بيع العقارات", "citizenship": "الجنسية التركية", "apartment": "شراء العقارات", "land": "الاستثمار في الأراضي", "general": "رؤى السوق"},
    "ru": {"sell": "ПРОДАЖА НЕДВИЖИМОСТИ", "citizenship": "ГРАЖДАНСТВО ТУРЦИИ", "apartment": "ПОКУПКА НЕДВИЖИМОСТИ", "land": "ИНВЕСТИЦИИ В ЗЕМЛЮ", "general": "ОБЗОР РЫНКА"},
}


def wrap(draw, text, fnt, max_w, direction=None, lang=None):
    words, lines, cur = text.split(), [], ""
    for w in words:
        trial = (cur + " " + w).strip()
        kw = {"direction": direction, "language": lang} if direction else {}
        if draw.textlength(trial, font=fnt, **kw) <= max_w or not cur:
            cur = trial
        else:
            lines.append(cur)
            cur = w
    if cur:
        lines.append(cur)
    return lines


def render_og(scene, title, lang, segment):
    W, H = 1200, 630
    scale = max(W / scene.width, H / scene.height)
    base = scene.resize((round(scene.width * scale), round(scene.height * scale)), Image.LANCZOS)
    left = (base.width - W) // 2
    top = max(0, (base.height - H) // 2 - 10)
    img = base.crop((left, top, left + W, top + H)).convert("RGB")
    rtl = lang == "ar"

    shade = Image.new("L", (W, H), 0)
    sd = ImageDraw.Draw(shade)
    for x in range(W):
        t = x / W
        v = int(225 * max(0.0, 1 - t * 1.25)) if not rtl else int(225 * max(0.0, 1 - (1 - t) * 1.25))
        sd.line([(x, 0), (x, H)], fill=v)
    img = Image.composite(Image.new("RGB", (W, H), (10, 10, 12)), img, shade)
    d = ImageDraw.Draw(img)

    pad = 64
    text_w = int(W * 0.62)
    if lang == "ar":
        tf_path, tf_var, cat_path, cat_var = DEJAVU_BOLD, None, DEJAVU_BOLD, None
        kw = {"direction": "rtl", "language": "ar"}
    else:
        tf_path, tf_var, cat_path, cat_var = ROBOTO, "Condensed Black", ROBOTO, "Condensed Bold"
        kw = {}
        title = title.upper()

    size = 72
    while size > 34:
        tf = font(tf_path, size, tf_var)
        lines = wrap(d, title, tf, text_w, kw.get("direction"), kw.get("language"))
        lh = int(size * (1.25 if rtl else 1.02))
        if len(lines) <= 4 and lh * len(lines) < H - 250:
            break
        size -= 4

    cat = CATEGORY[lang].get(segment, CATEGORY[lang]["general"])
    cf = font(cat_path, 22, cat_var)
    cw = d.textlength(cat, font=cf, **kw)
    cy = 70
    if rtl:
        d.rectangle([W - pad - cw - 28, cy, W - pad, cy + 42], fill=RED)
        d.text((W - pad - 14, cy + 21), cat, font=cf, fill="white", anchor="rm", **kw)
    else:
        d.rectangle([pad, cy, pad + cw + 28, cy + 42], fill=RED)
        d.text((pad + 14, cy + 21), cat, font=cf, fill="white", anchor="lm")

    y = cy + 80
    for ln in lines:
        if rtl:
            d.text((W - pad, y), ln, font=tf, fill="white", anchor="ra", **kw)
        else:
            d.text((pad, y), ln, font=tf, fill="white", anchor="la")
        y += lh

    bf = font(ROBOTO, 34, "Condensed Black")
    uf = font(ROBOTO, 22, "Condensed Regular")
    by = H - 78
    if rtl:
        d.text((W - pad, by), "LAND ISTANBUL", font=bf, fill=RED, anchor="ra")
        d.text((W - pad, by + 40), "landistanbul.com", font=uf, fill=(220, 220, 220), anchor="ra")
    else:
        d.text((pad, by), "LAND ISTANBUL", font=bf, fill=RED, anchor="la")
        d.text((pad, by + 40), "landistanbul.com", font=uf, fill=(220, 220, 220), anchor="la")
    d.rectangle([0, H - 6, W, H], fill=RED)
    return img


def main():
    if len(sys.argv) < 2:
        print(__doc__)
        sys.exit(1)
    post_path = Path(sys.argv[1])
    post = json.loads(post_path.read_text(encoding="utf-8"))
    group, segment = post["group"], post.get("segment", "general")
    img_dir = ROOT / "images"
    img_dir.mkdir(exist_ok=True)

    scene = render_scene(group, segment)
    hero_rel = f"images/{group}-hero.jpg"
    scene.save(ROOT / hero_rel, "JPEG", quality=84, optimize=True, progressive=True)

    images, og_images = {}, {}
    for lang, tr in post["translations"].items():
        og_rel = f"images/{group}-og-{lang}.jpg"
        render_og(scene, tr.get("og_title") or tr["title"], lang, segment).save(ROOT / og_rel, "JPEG", quality=86, optimize=True, progressive=True)
        images[lang] = hero_rel
        og_images[lang] = og_rel
    post["images"] = images
    post["og_images"] = og_images
    post_path.write_text(json.dumps(post, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print("hero:", hero_rel)
    for lang, rel in og_images.items():
        print(f"og[{lang}]:", rel)


if __name__ == "__main__":
    main()
