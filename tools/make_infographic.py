#!/usr/bin/env python3
"""
Land Istanbul in-article infographics.

Usage:
    python3 tools/make_infographic.py posts/<file>.json

Reads post["infographics"], a list of specs:
    {"name": "steps", "type": "steps", "title": {"en": "...", "ar": "...", "ru": "..."},
     "items": {"en": [["Short label", "one-line detail"], ...], "ar": [...], "ru": [...]}}
    {"name": "facts", "type": "facts", "title": {...},
     "items": {"en": [["$400,000", "minimum property value"], ...], ...}}
Writes images/<group>-<name>-<lang>.jpg (1200px wide) for every language.
Reference them in body_html as /blog-images/auto/<group>-<name>-<lang>.jpg
"""
import json
import sys
from pathlib import Path

from PIL import Image, ImageDraw, ImageFont, features

ROOT = Path(__file__).resolve().parent.parent
ROBOTO = "/usr/share/fonts/truetype/google-fonts/ofl/roboto/Roboto[wdth,wght].ttf"
DEJAVU_BOLD = "/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf"
DEJAVU = "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf"
RED, DARK, INK, PAPER, MUTED = (231, 0, 0), (23, 23, 23), (40, 40, 40), (255, 253, 239), (110, 110, 110)
LAYOUT = ImageFont.Layout.RAQM if features.check("raqm") else ImageFont.Layout.BASIC


def f(lang, size, bold=True):
    if lang == "ar":
        return ImageFont.truetype(DEJAVU_BOLD if bold else DEJAVU, size, layout_engine=LAYOUT)
    fnt = ImageFont.truetype(ROBOTO, size, layout_engine=LAYOUT)
    fnt.set_variation_by_name("Condensed Black" if bold else "Condensed Regular")
    return fnt


def kw(lang):
    return {"direction": "rtl", "language": "ar"} if lang == "ar" else {}


def wrap(d, text, fnt, max_w, lang):
    words, lines, cur = text.split(), [], ""
    for w in words:
        t = (cur + " " + w).strip()
        if d.textlength(t, font=fnt, **kw(lang)) <= max_w or not cur:
            cur = t
        else:
            lines.append(cur)
            cur = w
    if cur:
        lines.append(cur)
    return lines


def draw_text(d, xy_l, xy_r, text, fnt, fill, lang):
    if lang == "ar":
        d.text(xy_r, text, font=fnt, fill=fill, anchor="ra", **kw(lang))
    else:
        d.text(xy_l, text, font=fnt, fill=fill, anchor="la")


def steps(spec, lang):
    W, pad = 1200, 60
    title = spec["title"][lang]
    items = spec["items"][lang]
    scratch = ImageDraw.Draw(Image.new("RGB", (10, 10)))
    tf, lf, df = f(lang, 46), f(lang, 30), f(lang, 24, bold=False)
    title_lines = wrap(scratch, title if lang == "ar" else title.upper(), tf, W - 2 * pad, lang)
    rows = []
    for label, detail in items:
        ll = wrap(scratch, label, lf, W - 2 * pad - 110, lang)
        dl = wrap(scratch, detail, df, W - 2 * pad - 110, lang) if detail else []
        h = len(ll) * 38 + len(dl) * 32 + 34
        rows.append((ll, dl, max(h, 96)))
    H = pad + len(title_lines) * 56 + 40 + sum(r[2] for r in rows) + pad + 40
    img = Image.new("RGB", (W, H), PAPER)
    d = ImageDraw.Draw(img)
    d.rectangle([0, 0, W, 10], fill=RED)
    y = pad
    for ln in title_lines:
        draw_text(d, (pad, y), (W - pad, y), ln, tf, DARK, lang)
        y += 56
    y += 30
    for i, (ll, dl, h) in enumerate(rows):
        bx = pad if lang != "ar" else W - pad - 64
        d.rectangle([bx, y, bx + 64, y + 64], fill=RED)
        d.text((bx + 32, y + 32), str(i + 1), font=f("en", 36), fill="white", anchor="mm")
        if i < len(rows) - 1:
            cx = bx + 32
            d.line([(cx, y + 70), (cx, y + h - 6)], fill=(220, 200, 190), width=4)
        tx_l, tx_r = pad + 96, W - pad - 96
        yy = y + 4
        for ln in ll:
            draw_text(d, (tx_l, yy), (tx_r, yy), ln, lf, DARK, lang)
            yy += 38
        for ln in dl:
            draw_text(d, (tx_l, yy), (tx_r, yy), ln, df, MUTED, lang)
            yy += 32
        y += h
    brand = f("en", 26)
    d.text((W - pad if lang != "ar" else pad, H - 44), "LAND ISTANBUL", font=brand, fill=RED, anchor="rm" if lang != "ar" else "lm")
    d.rectangle([0, H - 8, W, H], fill=DARK)
    return img


def facts(spec, lang):
    W, pad = 1200, 60
    items = spec["items"][lang]
    cols = 2 if len(items) <= 4 else 3
    cell_w = (W - 2 * pad - (cols - 1) * 20) // cols
    scratch = ImageDraw.Draw(Image.new("RGB", (10, 10)))
    tf, vf, lf = f(lang, 44), f(lang, 50), f(lang, 24, bold=False)
    title_lines = wrap(scratch, spec["title"][lang] if lang == "ar" else spec["title"][lang].upper(), tf, W - 2 * pad, lang)
    cell_h = 0
    for value, label in items:
        n = len(wrap(scratch, label, lf, cell_w - 48, lang))
        cell_h = max(cell_h, 64 + 30 + n * 32 + 40)
    rows = (len(items) + cols - 1) // cols
    H = pad + len(title_lines) * 54 + 36 + rows * (cell_h + 20) + pad + 20
    img = Image.new("RGB", (W, H), DARK)
    d = ImageDraw.Draw(img)
    d.rectangle([0, 0, W, 10], fill=RED)
    y = pad
    for ln in title_lines:
        draw_text(d, (pad, y), (W - pad, y), ln, tf, "white", lang)
        y += 54
    y += 30
    for i, (value, label) in enumerate(items):
        r, c = divmod(i, cols)
        if lang == "ar":
            c = cols - 1 - c
        x0 = pad + c * (cell_w + 20)
        y0 = y + r * (cell_h + 20)
        d.rectangle([x0, y0, x0 + cell_w, y0 + cell_h], fill=(36, 36, 36))
        d.rectangle([x0, y0, x0 + 6, y0 + cell_h] if lang != "ar" else [x0 + cell_w - 6, y0, x0 + cell_w, y0 + cell_h], fill=RED)
        vx_l, vx_r = x0 + 28, x0 + cell_w - 28
        size = 50
        vfit = vf
        while size > 26 and d.textlength(value, font=vfit, **kw(lang)) > cell_w - 56:
            size -= 2
            vfit = f(lang, size)
        draw_text(d, (vx_l, y0 + 24 + (50 - size) // 2), (vx_r, y0 + 24 + (50 - size) // 2), value, vfit, (255, 90, 80), lang)
        yy = y0 + 24 + 70
        for ln in wrap(d, label, lf, cell_w - 56, lang):
            draw_text(d, (vx_l, yy), (vx_r, yy), ln, lf, (225, 225, 225), lang)
            yy += 32
    d.text((W - pad if lang != "ar" else pad, H - 36), "LAND ISTANBUL", font=f("en", 24), fill=RED, anchor="rm" if lang != "ar" else "lm")
    return img


def main():
    post_path = Path(sys.argv[1])
    post = json.loads(post_path.read_text(encoding="utf-8"))
    group = post["group"]
    for spec in post.get("infographics", []):
        for lang in post["translations"]:
            if lang not in spec["items"]:
                continue
            img = {"steps": steps, "facts": facts}[spec["type"]](spec, lang)
            out = ROOT / "images" / f"{group}-{spec['name']}-{lang}.jpg"
            img.save(out, "JPEG", quality=88, optimize=True, progressive=True)
            print(out.relative_to(ROOT), img.size)


if __name__ == "__main__":
    main()
