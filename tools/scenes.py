"""
Cover illustration styles for Land Istanbul posts (used by tools/make_cover.py).

Each style draws an original flat illustration at 1600x900 (rendered at 2x and downscaled for smooth edges).
Styles: passport, facade, isometric, aerial_land, chart, window, coast, keys (plus the Bosphorus "skyline" scene
that lives in make_cover.py). Every style accepts any palette from PAL.
"""
import math
import random

from PIL import Image, ImageDraw, ImageFilter

RED = (231, 0, 0)

PAL = {
    "cream": dict(bg=(250, 244, 232), bg2=(236, 222, 198), ink=(28, 26, 24), a=(212, 164, 112), b=(118, 150, 138), c=(70, 96, 120), light=(255, 255, 255), glass=(64, 92, 116)),
    "navy": dict(bg=(16, 28, 56), bg2=(34, 56, 98), ink=(8, 12, 26), a=(236, 186, 98), b=(92, 132, 194), c=(232, 226, 210), light=(250, 246, 236), glass=(40, 70, 120)),
    "teal": dict(bg=(14, 70, 76), bg2=(28, 110, 112), ink=(8, 34, 38), a=(244, 184, 122), b=(126, 196, 184), c=(240, 232, 214), light=(252, 248, 238), glass=(30, 80, 96)),
    "terracotta": dict(bg=(202, 104, 70), bg2=(234, 152, 108), ink=(48, 26, 20), a=(252, 228, 196), b=(98, 64, 52), c=(60, 104, 112), light=(255, 248, 236), glass=(86, 62, 70)),
    "sage": dict(bg=(212, 224, 204), bg2=(178, 202, 172), ink=(30, 44, 36), a=(240, 200, 120), b=(98, 132, 104), c=(66, 92, 120), light=(252, 250, 242), glass=(78, 110, 120)),
    "plum": dict(bg=(52, 28, 58), bg2=(96, 54, 96), ink=(22, 10, 26), a=(244, 164, 124), b=(160, 118, 178), c=(246, 230, 220), light=(252, 242, 236), glass=(70, 50, 100)),
    "sand": dict(bg=(240, 224, 194), bg2=(222, 196, 158), ink=(58, 40, 30), a=(66, 120, 152), b=(196, 132, 86), c=(120, 150, 110), light=(255, 252, 246), glass=(80, 110, 130)),
    "slate": dict(bg=(42, 48, 58), bg2=(70, 80, 96), ink=(18, 20, 26), a=(236, 200, 140), b=(132, 160, 184), c=(222, 226, 230), light=(248, 248, 250), glass=(54, 74, 98)),
}

S = 2  # supersampling


def lerp(a, b, t):
    t = max(0.0, min(1.0, t))
    return tuple(int(a[i] + (b[i] - a[i]) * t) for i in range(3))


def shade(c, f):
    return tuple(max(0, min(255, int(v * f))) for v in c)


def mix(a, b, t=0.5):
    return lerp(a, b, t)


def new(W, H, color):
    return Image.new("RGB", (W * S, H * S), color)


def finish(img, W, H):
    out = img.resize((W, H), Image.LANCZOS)
    ImageDraw.Draw(out).rectangle([0, H - 8, W, H], fill=RED)
    return out


def vgrad(d, box, top, bottom):
    x0, y0, x1, y1 = [int(v) for v in box]
    h = max(1, y1 - y0)
    for y in range(y0, y1):
        d.line([(x0, y), (x1, y)], fill=lerp(top, bottom, (y - y0) / h))


def soft_shadow(base, layer, offset=(18, 26), blur=22, alpha=110):
    a = layer.split()[3].point(lambda v: int(v * alpha / 255))
    sh = Image.new("RGBA", layer.size, (0, 0, 0, 0))
    sh.putalpha(a)
    sh = sh.filter(ImageFilter.GaussianBlur(blur * S))
    base.paste(sh, (offset[0] * S, offset[1] * S), sh)
    base.paste(layer, (0, 0), layer)


def rrect(d, box, r, **kw):
    d.rounded_rectangle([int(v) for v in box], radius=int(r), **kw)


def deco_circles(d, W, H, p, rng, n=5):
    for _ in range(n):
        r = rng.uniform(0.08, 0.28) * H * S
        x, y = rng.uniform(0, W * S), rng.uniform(0, H * S)
        d.ellipse([x - r, y - r, x + r, y + r], fill=mix(p["bg"], p["bg2"], rng.uniform(0.35, 0.8)))


# ───────────────────────── 1. passport & documents ─────────────────────────

def style_passport(p, rng, W=1600, H=900):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    deco_circles(d, W, H, p, rng, 4)
    # dotted pattern
    for y in range(40, H * S, 64):
        for x in range(40 + (y // 64 % 2) * 32, W * S, 64):
            d.ellipse([x - 3, y - 3, x + 3, y + 3], fill=mix(p["bg"], p["ink"], 0.08))
    base = img.convert("RGBA")

    def item(draw_fn, cx, cy, w, h, angle):
        lay = Image.new("RGBA", (int(w * S * 1.6), int(h * S * 1.6)), (0, 0, 0, 0))
        draw_fn(ImageDraw.Draw(lay), lay.width, lay.height, w * S, h * S)
        lay = lay.rotate(angle, resample=Image.BICUBIC, expand=True)
        full = Image.new("RGBA", base.size, (0, 0, 0, 0))
        full.paste(lay, (int(cx * S - lay.width / 2), int(cy * S - lay.height / 2)), lay)
        soft_shadow(base, full)

    book_col = rng.choice([(128, 18, 34), (22, 44, 88), (24, 70, 52), (70, 24, 52)])
    gold = (222, 184, 104)

    def passport(dd, LW, LH, w, h):
        x0, y0 = (LW - w) / 2, (LH - h) / 2
        rrect(dd, [x0, y0, x0 + w, y0 + h], 26 * S, fill=book_col)
        rrect(dd, [x0 + w - 18 * S, y0, x0 + w, y0 + h], 10 * S, fill=shade(book_col, 0.8))
        cx, cy, r = x0 + w / 2, y0 + h * 0.47, w * 0.24
        dd.ellipse([cx - r, cy - r, cx + r, cy + r], outline=gold, width=5 * S)
        for k in (0.35, 0.7):
            dd.ellipse([cx - r * k, cy - r, cx + r * k, cy + r], outline=gold, width=3 * S)
        dd.line([(cx - r, cy), (cx + r, cy)], fill=gold, width=3 * S)
        for f in (-0.5, 0.5):
            yy = cy + r * f
            half = math.sqrt(max(0, r * r - (r * f) ** 2))
            dd.line([(cx - half, yy), (cx + half, yy)], fill=gold, width=3 * S)
        for i, wf in enumerate((0.56, 0.4)):
            yy = y0 + h * (0.14 + i * 0.07)
            rrect(dd, [cx - w * wf / 2, yy, cx + w * wf / 2, yy + 12 * S], 6 * S, fill=gold)
        rrect(dd, [cx - w * 0.3, y0 + h * 0.8, cx + w * 0.3, y0 + h * 0.8 + 14 * S], 7 * S, fill=gold)
        # chip symbol
        rrect(dd, [cx - 26 * S, y0 + h * 0.88, cx + 26 * S, y0 + h * 0.88 + 30 * S], 6 * S, outline=gold, width=3 * S)

    def card(dd, LW, LH, w, h):
        x0, y0 = (LW - w) / 2, (LH - h) / 2
        rrect(dd, [x0, y0, x0 + w, y0 + h], 28 * S, fill=p["light"])
        rrect(dd, [x0, y0, x0 + w, y0 + h * 0.22], 28 * S, fill=p["c"] if p["c"] != p["light"] else p["b"])
        dd.rectangle([x0, y0 + h * 0.12, x0 + w, y0 + h * 0.22], fill=p["c"] if p["c"] != p["light"] else p["b"])
        px0, py0 = x0 + w * 0.07, y0 + h * 0.32
        rrect(dd, [px0, py0, px0 + w * 0.26, py0 + h * 0.56], 14 * S, fill=mix(p["light"], p["b"], 0.35))
        hx, hy, hr = px0 + w * 0.13, py0 + h * 0.2, w * 0.055
        dd.ellipse([hx - hr, hy - hr, hx + hr, hy + hr], fill=mix(p["light"], p["ink"], 0.45))
        dd.pieslice([hx - hr * 2, hy + hr * 0.9, hx + hr * 2, hy + hr * 4.6], 180, 360, fill=mix(p["light"], p["ink"], 0.45))
        for i, wf in enumerate((0.5, 0.42, 0.55, 0.3)):
            yy = y0 + h * (0.36 + i * 0.13)
            rrect(dd, [x0 + w * 0.4, yy, x0 + w * (0.4 + wf), yy + 13 * S], 6 * S, fill=mix(p["light"], p["ink"], 0.18 if i else 0.45))
        rrect(dd, [x0 + w * 0.78, y0 + h * 0.72, x0 + w * 0.92, y0 + h * 0.9], 8 * S, fill=gold)

    def keys(dd, LW, LH, w, h):
        cx, cy = LW / 2, LH / 2
        ring_r = w * 0.16
        dd.ellipse([cx - w * 0.36 - ring_r, cy - h * 0.25 - ring_r, cx - w * 0.36 + ring_r, cy - h * 0.25 + ring_r], outline=(200, 200, 206), width=7 * S)
        # key
        kx, ky = cx - w * 0.2, cy - h * 0.1
        kr = w * 0.13
        col = (214, 176, 96)
        dd.ellipse([kx - kr, ky - kr, kx + kr, ky + kr], fill=col)
        dd.ellipse([kx - kr * 0.38, ky - kr * 0.38, kx + kr * 0.38, ky + kr * 0.38], fill=(0, 0, 0, 0))
        dd.rectangle([kx + kr * 0.8, ky - kr * 0.2, kx + w * 0.55, ky + kr * 0.2], fill=col)
        for t in (0.32, 0.42, 0.52):
            dd.rectangle([kx + w * t, ky + kr * 0.2, kx + w * t + 14 * S, ky + kr * 0.55], fill=col)
        # house tag
        tx, ty, ts = cx - w * 0.36, cy + h * 0.12, w * 0.2
        dd.polygon([(tx - ts, ty), (tx, ty - ts * 0.8), (tx + ts, ty), (tx + ts, ty + ts * 1.1), (tx - ts, ty + ts * 1.1)], fill=RED)
        dd.rectangle([tx - ts * 0.25, ty + ts * 0.45, tx + ts * 0.25, ty + ts * 1.1], fill=shade(RED, 0.7))
        dd.line([(tx, ty - ts * 0.8), (cx - w * 0.36, cy - h * 0.25 + ring_r)], fill=(200, 200, 206), width=5 * S)

    def stamp(dd, LW, LH, w, h):
        cx, cy, r = LW / 2, LH / 2, w / 2
        col = RED + (150,)
        dd.ellipse([cx - r, cy - r, cx + r, cy + r], outline=col, width=8 * S)
        dd.ellipse([cx - r * 0.78, cy - r * 0.78, cx + r * 0.78, cy + r * 0.78], outline=col, width=4 * S)
        for k in range(12):
            a = k * math.pi / 6
            x, y = cx + math.cos(a) * r * 0.89, cy + math.sin(a) * r * 0.89
            dd.ellipse([x - 5 * S, y - 5 * S, x + 5 * S, y + 5 * S], fill=col)
        rrect(dd, [cx - r * 0.5, cy - 9 * S, cx + r * 0.5, cy + 9 * S], 8 * S, fill=col)

    def pen(dd, LW, LH, w, h):
        x0, y0 = (LW - w) / 2, (LH - h) / 2
        rrect(dd, [x0, y0, x0 + w * 0.86, y0 + h], h / 2, fill=p["ink"])
        dd.polygon([(x0 + w * 0.86, y0), (x0 + w, y0 + h / 2), (x0 + w * 0.86, y0 + h)], fill=(214, 176, 96))
        dd.rectangle([x0 + w * 0.12, y0 - h * 0.15, x0 + w * 0.5, y0 + h * 0.15], fill=(214, 176, 96))

    flip = rng.random() < 0.5
    px = 560 if not flip else 1040
    cxr = 1080 if not flip else 520
    item(passport, px, 440, 400, 560, rng.uniform(-11, -4) * (1 if not flip else -1))
    item(card, cxr, 330, 520, 330, rng.uniform(4, 9) * (1 if not flip else -1))
    item(keys, cxr + (90 if not flip else -90), 680, 420, 300, rng.uniform(-14, 14))
    item(pen, 1300 if not flip else 300, 150, 360, 34, rng.uniform(-25, -10))
    stamp_l = Image.new("RGBA", base.size, (0, 0, 0, 0))
    st = Image.new("RGBA", (260 * S, 260 * S), (0, 0, 0, 0))
    stamp(ImageDraw.Draw(st), st.width, st.height, 220 * S, 220 * S)
    st = st.rotate(rng.uniform(-30, 30), resample=Image.BICUBIC)
    stamp_l.paste(st, (int((px + (170 if not flip else -170)) * S - st.width / 2), int(650 * S - st.height / 2)), st)
    base.paste(stamp_l, (0, 0), stamp_l)
    return finish(base.convert("RGB"), W, H)


# ───────────────────────── 2. apartment facade ─────────────────────────

def style_facade(p, rng, W=1600, H=900):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    vgrad(d, [0, 0, W * S, H * S], p["bg2"], p["bg"])
    sx, sy, sr = rng.uniform(0.12, 0.3) * W * S, rng.uniform(0.15, 0.3) * H * S, 70 * S
    d.ellipse([sx - sr, sy - sr, sx + sr, sy + sr], fill=mix(p["a"], p["light"], 0.4))
    # clouds
    for _ in range(3):
        cx, cy = rng.uniform(0, W * S), rng.uniform(0.08, 0.35) * H * S
        for k in range(3):
            r = rng.uniform(30, 60) * S
            d.ellipse([cx + k * 50 * S - r, cy - r * 0.6, cx + k * 50 * S + r, cy + r * 0.6], fill=mix(p["bg2"], p["light"], 0.5))

    def building(x0, top, w, color, cols, balcony, lit_p):
        bottom = H * S
        d.rectangle([x0, top, x0 + w, bottom], fill=color)
        d.rectangle([x0 - 10 * S, top - 16 * S, x0 + w + 10 * S, top], fill=shade(color, 0.85))
        floor_h = 92 * S
        cw = w / cols
        y = top + 34 * S
        while y + floor_h < bottom - 40 * S:
            for c in range(cols):
                wx = x0 + c * cw + cw * 0.16
                ww = cw * 0.68
                lit = rng.random() < lit_p
                glass = mix(p["glass"], (255, 214, 140), 0.75) if lit else p["glass"]
                d.rectangle([wx, y, wx + ww, y + floor_h * 0.62], fill=glass)
                if not lit:
                    d.polygon([(wx + ww * 0.15, y), (wx + ww * 0.42, y), (wx + ww * 0.12, y + floor_h * 0.62), (wx, y + floor_h * 0.62), (wx, y + floor_h * 0.3)], fill=mix(glass, p["light"], 0.18))
                d.line([(wx + ww / 2, y), (wx + ww / 2, y + floor_h * 0.62)], fill=shade(color, 0.8), width=3 * S)
                if balcony and c % 2 == 0:
                    by = y + floor_h * 0.62
                    d.rectangle([wx - cw * 0.08, by, wx + ww + cw * 0.08, by + 9 * S], fill=shade(color, 0.78))
                    d.rectangle([wx - cw * 0.06, by - floor_h * 0.26, wx + ww + cw * 0.06, by], outline=shade(color, 0.7), width=3 * S)
                    if rng.random() < 0.45:
                        pr = 16 * S
                        px = wx + rng.uniform(0.1, 0.9) * ww
                        d.ellipse([px - pr, by - pr * 1.8, px + pr, by - pr * 0.2], fill=p["b"] if p["b"] != color else p["c"])
                    if rng.random() < 0.12:
                        d.polygon([(wx - cw * 0.06, y - 6 * S), (wx + ww + cw * 0.06, y - 6 * S), (wx + ww + cw * 0.12, y + 26 * S), (wx - cw * 0.12, y + 26 * S)], fill=RED)
            y += floor_h

    back = shade(mix(p["bg2"], p["ink"], 0.25), 1.0)
    building(-60 * S, 260 * S, 520 * S, back, 4, False, 0.2)
    building(1180 * S, 180 * S, 520 * S, mix(back, p["c"], 0.3), 4, False, 0.2)
    main = p["light"] if sum(p["bg"]) < 400 else mix(p["light"], p["a"], 0.18)
    building(380 * S, 70 * S, 860 * S, main, 6, True, 0.25)
    # trees and street
    d.rectangle([0, (H - 70) * S, W * S, H * S], fill=mix(p["ink"], p["bg"], 0.3))
    for _ in range(9):
        tx = rng.uniform(0, W) * S
        r = rng.uniform(55, 90) * S
        ty = (H - 70) * S - r * 0.7
        d.rectangle([tx - 6 * S, ty, tx + 6 * S, (H - 70) * S], fill=shade(p["ink"], 1.6))
        d.ellipse([tx - r, ty - r, tx + r, ty + r * 0.8], fill=mix(p["b"], (60, 110, 70), 0.55))
    return finish(img, W, H)


# ───────────────────────── 3. isometric neighbourhood ─────────────────────────

def style_isometric(p, rng, W=1600, H=900):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    deco_circles(d, W, H, p, rng, 3)
    tw, th = 130 * S, 65 * S
    ox, oy = W * S / 2, 250 * S
    n = 9

    def iso(i, j, z=0):
        return ox + (i - j) * tw / 2, oy + (i + j) * th / 2 - z

    ground = mix(p["bg2"], p["light"], 0.25)
    road = mix(p["ink"], p["bg"], 0.35)
    roads = {3, 6}
    hi = rng.choice([(i, j) for i in (2, 4, 5, 7) for j in (2, 4, 5, 7) if i + j >= 7])
    for s in range(2 * n):
        for i in range(n):
            j = s - i
            if not 0 <= j < n:
                continue
            is_road = i in roads or j in roads
            t = [iso(i, j), iso(i + 1, j), iso(i + 1, j + 1), iso(i, j + 1)]
            d.polygon(t, fill=road if is_road else ground)
            if is_road:
                if i in roads and j not in roads:
                    a, b = iso(i + 0.5, j + 0.2), iso(i + 0.5, j + 0.8)
                    d.line([a, b], fill=mix(road, p["light"], 0.6), width=3 * S)
                elif j in roads and i not in roads:
                    a, b = iso(i + 0.2, j + 0.5), iso(i + 0.8, j + 0.5)
                    d.line([a, b], fill=mix(road, p["light"], 0.6), width=3 * S)
                continue
            r = rng.random()
            if (i, j) == hi:
                h = 230 * S
                top_c = RED
            elif r < 0.22:
                # tree
                cx, cy = iso(i + 0.5, j + 0.5)
                tr = 26 * S
                d.rectangle([cx - 4 * S, cy - 30 * S, cx + 4 * S, cy], fill=shade(p["ink"], 1.5))
                d.ellipse([cx - tr, cy - 30 * S - tr * 1.4, cx + tr, cy - 30 * S + tr * 0.4], fill=mix(p["b"], (70, 130, 80), 0.5))
                continue
            elif r < 0.3:
                continue
            else:
                h = rng.choice([50, 80, 110, 150, 190] if i + j > 3 else [40, 70, 100]) * S
                top_c = rng.choice([p["a"], p["b"], p["c"], p["light"]])
            m = 0.12
            a, b, c, e = iso(i + m, j + m), iso(i + 1 - m, j + m), iso(i + 1 - m, j + 1 - m), iso(i + m, j + 1 - m)
            up = lambda q: (q[0], q[1] - h)
            d.polygon([e, c, up(c), up(e)], fill=shade(top_c, 0.72))
            d.polygon([c, b, up(b), up(c)], fill=shade(top_c, 0.86))
            d.polygon([up(a), up(b), up(c), up(e)], fill=top_c)
            # windows
            rows = int(h / (26 * S))
            for k in range(1, rows):
                for f in (0.3, 0.7):
                    x1 = e[0] + (c[0] - e[0]) * f
                    y1 = e[1] + (c[1] - e[1]) * f - k * 26 * S
                    d.polygon([(x1 - 6 * S, y1 - 3 * S), (x1 + 6 * S, y1 + 3 * S), (x1 + 6 * S, y1 - 9 * S), (x1 - 6 * S, y1 - 15 * S)], fill=shade(top_c, 0.55))
                    x2 = c[0] + (b[0] - c[0]) * f
                    y2 = c[1] + (b[1] - c[1]) * f - k * 26 * S
                    d.polygon([(x2 - 6 * S, y2 + 3 * S), (x2 + 6 * S, y2 - 3 * S), (x2 + 6 * S, y2 - 15 * S), (x2 - 6 * S, y2 - 9 * S)], fill=shade(top_c, 0.66))
            if (i, j) == hi:
                cx, cy = iso(i + 0.5, j + 0.5, h + 120 * S)
                pr = 44 * S
                d.polygon([(cx - pr * 0.8, cy + pr * 0.5), (cx + pr * 0.8, cy + pr * 0.5), (cx, cy + pr * 2.2)], fill=p["ink"])
                d.ellipse([cx - pr, cy - pr, cx + pr, cy + pr], fill=p["ink"])
                d.ellipse([cx - pr * 0.42, cy - pr * 0.42, cx + pr * 0.42, cy + pr * 0.42], fill=p["light"])
    return finish(img, W, H)


# ───────────────────────── 4. aerial land plots ─────────────────────────

def style_aerial_land(p, rng, W=1600, H=900):
    big = 2400
    img = Image.new("RGB", (big * S, big * S), (110, 140, 80))
    d = ImageDraw.Draw(img)
    greens = [(118, 150, 82), (148, 170, 92), (96, 128, 70), (190, 176, 104), (170, 150, 92), (132, 160, 100), (204, 190, 128)]
    greens = [mix(g, p["bg"], 0.18) for g in greens]
    cell = 220 * S
    plots = []
    for gy in range(0, big * S, cell):
        for gx in range(0, big * S, cell):
            j = lambda: rng.uniform(-28, 28) * S
            poly = [(gx + j(), gy + j()), (gx + cell + j(), gy + j()), (gx + cell + j(), gy + cell + j()), (gx + j(), gy + cell + j())]
            col = rng.choice(greens)
            d.polygon(poly, fill=col, outline=mix(col, (60, 70, 40), 0.35))
            if rng.random() < 0.5:
                horiz = rng.random() < 0.5
                for k in range(1, 9):
                    if horiz:
                        y = gy + cell * k / 9
                        d.line([(gx + 10 * S, y), (gx + cell - 10 * S, y)], fill=shade(col, 0.9), width=3 * S)
                    else:
                        x = gx + cell * k / 9
                        d.line([(x, gy + 10 * S), (x, gy + cell - 10 * S)], fill=shade(col, 0.9), width=3 * S)
            plots.append(poly)
    # river
    pts = []
    x0 = rng.uniform(0.2, 0.4) * big * S
    for k in range(60):
        y = k * big * S / 59
        pts.append((x0 + math.sin(k / 6.0) * 160 * S + k * 6 * S, y))
    d.line(pts, fill=mix(p["c"], (80, 140, 190), 0.6), width=46 * S, joint="curve")
    # road
    rp = []
    y0 = rng.uniform(0.45, 0.6) * big * S
    for k in range(60):
        x = k * big * S / 59
        rp.append((x, y0 + math.sin(k / 8.0) * 120 * S))
    d.line(rp, fill=(220, 214, 196), width=34 * S, joint="curve")
    d.line(rp, fill=(150, 146, 136), width=4 * S, joint="curve")
    # tree clusters
    for _ in range(140):
        x, y = rng.uniform(0, big * S), rng.uniform(0, big * S)
        r = rng.uniform(14, 30) * S
        d.ellipse([x - r, y - r, x + r, y + r], fill=(58, 92, 52))
        d.ellipse([x - r * 0.6, y - r * 0.8, x + r * 0.3, y - r * 0.1], fill=(82, 120, 66))
    # highlighted plot
    mid = big * S / 2
    hp = min(plots, key=lambda q: (sum(v[0] for v in q) / 4 - mid - rng.uniform(-1, 1) * cell) ** 2 + (sum(v[1] for v in q) / 4 - mid) ** 2)
    over = Image.new("RGBA", img.size, (0, 0, 0, 0))
    od = ImageDraw.Draw(over)
    od.polygon(hp, fill=RED + (70,))
    for a, b in zip(hp, hp[1:] + hp[:1]):
        n = 10
        for k in range(n):
            if k % 2 == 0:
                p1 = (a[0] + (b[0] - a[0]) * k / n, a[1] + (b[1] - a[1]) * k / n)
                p2 = (a[0] + (b[0] - a[0]) * (k + 1) / n, a[1] + (b[1] - a[1]) * (k + 1) / n)
                od.line([p1, p2], fill=RED + (255,), width=10 * S)
    for q in hp:
        od.ellipse([q[0] - 14 * S, q[1] - 14 * S, q[0] + 14 * S, q[1] + 14 * S], fill=(255, 255, 255, 255), outline=RED + (255,), width=5 * S)
    img.paste(over, (0, 0), over)
    cx = sum(q[0] for q in hp) / 4
    cy = sum(q[1] for q in hp) / 4
    img = img.rotate(rng.uniform(-14, 14), resample=Image.BICUBIC, center=(cx, cy), fillcolor=greens[0])
    left, top = int(cx - W * S * 0.55), int(cy - H * S * 0.5)
    img = img.crop((left, top, left + W * S, top + H * S))
    d = ImageDraw.Draw(img)
    # pin above highlighted plot
    px, py = W * S * 0.55, H * S * 0.5 - 70 * S
    pr = 52 * S
    sh = Image.new("RGBA", img.size, (0, 0, 0, 0))
    ImageDraw.Draw(sh).ellipse([px - 40 * S, py + 120 * S, px + 40 * S, py + 140 * S], fill=(0, 0, 0, 90))
    img.paste(sh, (0, 0), sh)
    d.polygon([(px - pr * 0.82, py + pr * 0.5), (px + pr * 0.82, py + pr * 0.5), (px, py + pr * 2.5)], fill=p["ink"])
    d.ellipse([px - pr, py - pr, px + pr, py + pr], fill=p["ink"])
    d.ellipse([px - pr * 0.42, py - pr * 0.42, px + pr * 0.42, py + pr * 0.42], fill=(255, 255, 255))
    return finish(img, W, H)


# ───────────────────────── 5. market chart ─────────────────────────

def style_chart(p, rng, W=1600, H=900):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    vgrad(d, [0, 0, W * S, H * S], p["bg"], p["bg2"])
    grid = mix(p["bg"], p["light"] if sum(p["bg"]) < 400 else p["ink"], 0.1)
    for y in range(120, H - 60, 90):
        d.line([(80 * S, y * S), ((W - 80) * S, y * S)], fill=grid, width=2 * S)
    # skyline silhouette at the bottom
    x = 0
    sil = mix(p["bg2"], p["ink"], 0.35)
    while x < W:
        w = rng.randint(30, 80)
        h = rng.randint(40, 160)
        d.rectangle([x * S, (H - h) * S, (x + w) * S, H * S], fill=sil)
        if rng.random() < 0.15:
            cx = x + w / 2
            r = w * 0.5
            d.pieslice([(cx - r) * S, (H - h - r) * S, (cx + r) * S, (H - h + r) * S], 180, 360, fill=sil)
            d.rectangle([(cx - 3) * S, (H - h - r - 40) * S, (cx + 3) * S, (H - h - r) * S], fill=sil)
        x += w + rng.randint(0, 6)
    # bars
    n = 8
    bx0, bx1, base = 180, 1060, 760
    bw = (bx1 - bx0) / n * 0.62
    vals = sorted(rng.uniform(0.25, 1.0) for _ in range(n))
    vals = [v * rng.uniform(0.92, 1.0) for v in vals]
    pts = []
    for i, v in enumerate(vals):
        x = bx0 + i * (bx1 - bx0) / n
        h = v * 520
        col = p["a"] if i < n - 1 else RED
        rrect(d, [x * S, (base - h) * S, (x + bw) * S, base * S], 10 * S, fill=col)
        pts.append(((x + bw / 2) * S, (base - h - 60) * S))
    d.line(pts, fill=p["light"] if sum(p["bg"]) < 400 else p["ink"], width=6 * S, joint="curve")
    for q in pts:
        d.ellipse([q[0] - 12 * S, q[1] - 12 * S, q[0] + 12 * S, q[1] + 12 * S], fill=p["light"], outline=p["ink"], width=4 * S)
    ax, ay = pts[-1]
    d.polygon([(ax + 30 * S, ay - 40 * S), (ax + 80 * S, ay - 70 * S), (ax + 70 * S, ay - 12 * S)], fill=RED)
    # coins
    cx0 = 1300
    for stack in range(3):
        cx = cx0 + (stack - 1) * 150
        count = rng.randint(4, 9) + stack * 2
        for k in range(count):
            cy = 760 - k * 26
            d.ellipse([(cx - 62) * S, (cy - 20) * S, (cx + 62) * S, (cy + 20) * S], fill=shade((222, 180, 90), 0.8))
            d.ellipse([(cx - 62) * S, (cy - 30) * S, (cx + 62) * S, (cy + 10) * S], fill=(232, 192, 104))
            d.ellipse([(cx - 44) * S, (cy - 24) * S, (cx + 44) * S, (cy + 4) * S], outline=(250, 220, 150), width=3 * S)
    return finish(img, W, H)


# ───────────────────────── 6. room with a view ─────────────────────────

def style_window(p, rng, W=1600, H=900, view=None):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    wall = mix(p["bg"], p["light"], 0.15)
    d.rectangle([0, 0, W * S, H * S], fill=wall)
    floor_y = 700
    vgrad(d, [0, floor_y * S, W * S, H * S], mix(p["a"], p["ink"], 0.35), mix(p["a"], p["ink"], 0.55))
    # window with view
    wx0, wy0, wx1, wy1 = 330, 70, 1270, 610
    if view is not None:
        v = view.resize(((wx1 - wx0) * S, (wy1 - wy0) * S), Image.LANCZOS)
        img.paste(v, (wx0 * S, wy0 * S))
    frame = mix(p["light"], p["ink"], 0.08)
    d.rectangle([wx0 * S, wy0 * S, wx1 * S, wy1 * S], outline=frame, width=22 * S)
    for f in (1 / 3, 2 / 3):
        x = wx0 + (wx1 - wx0) * f
        d.rectangle([(x - 7) * S, wy0 * S, (x + 7) * S, wy1 * S], fill=frame)
    d.rectangle([(wx0 - 30) * S, wy1 * S, (wx1 + 30) * S, (wy1 + 24) * S], fill=shade(frame, 0.9))
    # curtains
    cur = mix(p["c"], p["bg"], 0.2)
    for side in (0, 1):
        x0 = (wx0 - 170) if side == 0 else (wx1 + 20)
        d.rectangle([x0 * S, 40 * S, (x0 + 150) * S, (floor_y + 20) * S], fill=cur)
        for k in range(4):
            xx = x0 + 18 + k * 36
            d.line([(xx * S, 40 * S), (xx * S, (floor_y + 20) * S)], fill=shade(cur, 0.85), width=5 * S)
    d.rectangle([(wx0 - 200) * S, 30 * S, (wx1 + 200) * S, 44 * S], fill=shade(p["ink"], 1.4))
    # rug
    d.ellipse([300 * S, 780 * S, 1300 * S, 880 * S], fill=mix(p["b"], p["light"], 0.3))
    # sofa
    sofa = p["b"] if p["b"] != wall else p["c"]
    rrect(d, [420 * S, 560 * S, 1180 * S, 700 * S], 40 * S, fill=shade(sofa, 0.85))
    rrect(d, [380 * S, 640 * S, 1220 * S, 800 * S], 40 * S, fill=sofa)
    rrect(d, [360 * S, 600 * S, 460 * S, 800 * S], 36 * S, fill=shade(sofa, 0.92))
    rrect(d, [1140 * S, 600 * S, 1240 * S, 800 * S], 36 * S, fill=shade(sofa, 0.92))
    for k, col in enumerate((RED, p["a"], mix(p["light"], p["a"], 0.4))):
        x = 500 + k * 200
        rrect(d, [x * S, 570 * S, (x + 150) * S, 670 * S], 26 * S, fill=col)
    d.rectangle([420 * S, 800 * S, 440 * S, 830 * S], fill=p["ink"])
    d.rectangle([1160 * S, 800 * S, 1180 * S, 830 * S], fill=p["ink"])
    # plant
    px = 1400
    rrect(d, [(px - 50) * S, 700 * S, (px + 50) * S, 820 * S], 14 * S, fill=mix(p["a"], p["ink"], 0.2))
    for k in range(9):
        ang = -math.pi / 2 + (k - 4) * 0.28
        lx, ly = px + math.cos(ang) * 150, 700 + math.sin(ang) * 210
        d.line([(px * S, 700 * S), (lx * S, ly * S)], fill=(52, 100, 60), width=5 * S)
        d.ellipse([(lx - 28) * S, (ly - 48) * S, (lx + 28) * S, (ly + 48) * S], fill=(64 + k * 4, 122, 72))
    # floor lamp
    lx = 190
    d.line([(lx * S, 220 * S), (lx * S, 820 * S)], fill=p["ink"], width=8 * S)
    d.ellipse([(lx - 60) * S, 810 * S, (lx + 60) * S, 840 * S], fill=p["ink"])
    d.polygon([((lx - 80) * S, 260 * S), ((lx + 80) * S, 260 * S), ((lx + 50) * S, 160 * S), ((lx - 50) * S, 160 * S)], fill=p["a"])
    return finish(img, W, H)


# ───────────────────────── 7. coast ─────────────────────────

def style_coast(p, rng, W=1600, H=900):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    hz = 470
    sky_top = mix(p["bg2"], (120, 180, 230), 0.5)
    vgrad(d, [0, 0, W * S, hz * S], sky_top, mix(p["light"], (250, 220, 180), 0.4))
    sx, sr = rng.uniform(0.2, 0.8) * W, 70
    d.ellipse([(sx - sr) * S, 120 * S, (sx + sr) * S, (120 + 2 * sr) * S], fill=(255, 236, 190))
    # mountains
    for layer, (col, amp, base) in enumerate([(mix((120, 140, 170), p["bg2"], 0.3), 210, hz - 20), (mix((80, 110, 110), p["b"], 0.3), 140, hz)]):
        pts = [(0, hz * S)]
        ph = rng.uniform(0, 6)
        for x in range(0, W + 20, 20):
            y = base - amp * (0.5 + 0.5 * math.sin(x / (230 + layer * 60) + ph)) * (0.7 + 0.3 * math.sin(x / 90 + ph))
            pts.append((x * S, y * S))
        pts.append((W * S, hz * S))
        d.polygon(pts, fill=col)
    # sea
    vgrad(d, [0, hz * S, W * S, H * S], mix((40, 140, 170), p["c"], 0.25), mix((10, 70, 110), p["ink"], 0.2))
    for k in range(40):
        y = hz + 10 + k * 11
        x = rng.uniform(0, W)
        d.line([(x * S, y * S), ((x + rng.uniform(40, 160)) * S, y * S)], fill=(200, 230, 240), width=2 * S)
    # hillside town (right) and beach
    beach = [(W * 0.52 * S, H * S), (W * 0.62 * S, (hz + 120) * S), (W * S, (hz + 40) * S), (W * S, H * S)]
    d.polygon(beach, fill=(236, 214, 170))
    hill = [(W * 0.6 * S, (hz + 130) * S), (W * 0.72 * S, (hz - 80) * S), (W * S, (hz - 160) * S), (W * S, (hz + 60) * S)]
    d.polygon(hill, fill=mix((96, 130, 80), p["b"], 0.2))
    for _ in range(60):
        x = rng.uniform(0.66, 0.99) * W
        top = hz - 150 + (W - x) * 0.6 + rng.uniform(-20, 40)
        w, h = rng.uniform(26, 50), rng.uniform(22, 40)
        col = rng.choice([(250, 248, 240), (246, 236, 220), mix(p["a"], (255, 255, 255), 0.6)])
        d.rectangle([x * S, top * S, (x + w) * S, (top + h) * S], fill=col)
        d.rectangle([x * S, (top - 5) * S, (x + w) * S, top * S], fill=(190, 90, 60))
        for k in range(2):
            d.rectangle([(x + 6 + k * w / 2) * S, (top + 9) * S, (x + 12 + k * w / 2) * S, (top + 18) * S], fill=(60, 90, 120))
    # palms
    def palm(x, y, h, lean):
        pts = [((x + lean * (t ** 2) * h * 0.3) * S, (y - t * h) * S) for t in [k / 12 for k in range(13)]]
        d.line(pts, fill=(110, 80, 50), width=14 * S, joint="curve")
        tx, ty = pts[-1]
        for k in range(8):
            ang = -math.pi + k * math.pi / 7
            ex, ey = tx + math.cos(ang) * 120 * S, ty + math.sin(ang) * 60 * S + 40 * S
            mx, my = tx + math.cos(ang) * 60 * S, ty - 30 * S
            d.line([(tx, ty), (mx, my), (ex, ey)], fill=(46, 120, 70), width=16 * S, joint="curve")
    palm(1160, 870, 330, 1)
    palm(1420, 890, 270, 1)
    # sailboats
    for _ in range(3):
        bx, by = rng.uniform(100, 900), rng.uniform(hz + 60, H - 120)
        s = 0.6 + (by - hz) / 400
        d.polygon([((bx - 40 * s) * S, by * S), ((bx + 40 * s) * S, by * S), ((bx + 28 * s) * S, (by + 14 * s) * S), ((bx - 28 * s) * S, (by + 14 * s) * S)], fill=(250, 250, 250))
        d.polygon([(bx * S, (by - 90 * s) * S), (bx * S, (by - 4) * S), ((bx + 46 * s) * S, (by - 4) * S)], fill=(255, 255, 255))
        d.polygon([((bx - 3) * S, (by - 80 * s) * S), ((bx - 3) * S, (by - 4) * S), ((bx - 34 * s) * S, (by - 4) * S)], fill=RED)
    return finish(img, W, H)


# ───────────────────────── 8. keys & door ─────────────────────────

def style_keys(p, rng, W=1600, H=900):
    img = new(W, H, p["bg"])
    d = ImageDraw.Draw(img)
    # tiled house icons
    ic = mix(p["bg"], p["light"] if sum(p["bg"]) < 400 else p["ink"], 0.07)
    for gy in range(0, H + 120, 120):
        for gx in range((gy // 120 % 2) * 60, W + 120, 120):
            x, y, s = gx * S, gy * S, 22 * S
            d.polygon([(x - s, y), (x, y - s * 0.9), (x + s, y), (x + s * 0.8, y), (x + s * 0.8, y + s), (x - s * 0.8, y + s), (x - s * 0.8, y)], fill=ic)
    base = img.convert("RGBA")
    # door
    lay = Image.new("RGBA", base.size, (0, 0, 0, 0))
    ld = ImageDraw.Draw(lay)
    dx0 = 980 if rng.random() < 0.5 else 300
    door = rng.choice([p["c"], p["b"], (24, 70, 92), (120, 40, 40)])
    ld.rectangle([(dx0 - 30) * S, 90 * S, (dx0 + 350) * S, 900 * S], fill=mix(p["light"], p["ink"], 0.08))
    rrect(ld, [dx0 * S, 120 * S, (dx0 + 320) * S, 900 * S], 8 * S, fill=door)
    for (y0, y1) in ((170, 470), (520, 840)):
        rrect(ld, [(dx0 + 40) * S, y0 * S, (dx0 + 280) * S, y1 * S], 6 * S, outline=shade(door, 0.75), width=8 * S)
    ld.ellipse([(dx0 + 260) * S, 500 * S, (dx0 + 290) * S, 530 * S], fill=(222, 184, 104))
    ld.rectangle([(dx0 + 120) * S, 40 * S, (dx0 + 200) * S, 82 * S], fill=RED)
    soft_shadow(base, lay, (14, 10), 18, 90)
    # big key with tag
    lay = Image.new("RGBA", (900 * S, 420 * S), (0, 0, 0, 0))
    kd = ImageDraw.Draw(lay)
    gold = (226, 186, 100)
    kd.ellipse([40 * S, 110 * S, 240 * S, 310 * S], fill=gold)
    kd.ellipse([105 * S, 175 * S, 175 * S, 245 * S], fill=(0, 0, 0, 0))
    kd.rectangle([220 * S, 190 * S, 760 * S, 230 * S], fill=gold)
    for x, h in ((560, 60), (620, 44), (680, 70)):
        kd.rectangle([x * S, 230 * S, (x + 36) * S, (230 + h) * S], fill=gold)
    kd.line([(140 * S, 120 * S), (140 * S, 30 * S)], fill=(190, 190, 196), width=8 * S)
    tag = [(60 * S, 70 * S), (140 * S, 0), (220 * S, 70 * S), (220 * S, 160 * S), (60 * S, 160 * S)]
    lay2 = Image.new("RGBA", lay.size, (0, 0, 0, 0))
    td = ImageDraw.Draw(lay2)
    td.polygon([(q[0] + 80 * S, q[1] + 230 * S) for q in tag], fill=RED)
    td.rectangle([195 * S, 330 * S, 245 * S, 390 * S], fill=shade(RED, 0.7))
    td.line([(140 * S, 300 * S), (220 * S, 230 * S)], fill=(190, 190, 196), width=6 * S)
    lay.paste(lay2, (0, 0), lay2)
    lay = lay.rotate(rng.uniform(-20, -6), resample=Image.BICUBIC, expand=True)
    full = Image.new("RGBA", base.size, (0, 0, 0, 0))
    kx = 120 if dx0 > 600 else 760
    full.paste(lay, (kx * S, int(200 * S)), lay)
    soft_shadow(base, full, (20, 30), 24, 120)
    return finish(base.convert("RGB"), W, H)


STYLES = {
    "passport": style_passport,
    "facade": style_facade,
    "isometric": style_isometric,
    "aerial_land": style_aerial_land,
    "chart": style_chart,
    "window": style_window,
    "coast": style_coast,
    "keys": style_keys,
}
