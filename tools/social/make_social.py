#!/usr/bin/env python3
"""Build a daily social post (Instagram/TikTok carousel + YouTube Short) from a JSON spec.

Usage:
  python3 tools/social/make_social.py social/specs/<date>-<slug>.json            # slides only
  python3 tools/social/make_social.py social/specs/<date>-<slug>.json --short voice.wav

Spec format: see social/specs/EXAMPLE.json and SOCIAL.md.
Outputs:
  media/<slug>-1.jpg ... media/<slug>-N.jpg   (1080x1350, served at https://landistanbul.com/media/)
  media/<slug>-short.mp4                       (1080x1920, when --short is given)
  build/social/<slug>/                         (PNG working files, not committed)
"""
import asyncio, html, json, os, subprocess, sys

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
E = html.escape

CSS = r"""
*{margin:0;padding:0;box-sizing:border-box}
body{background:#888;font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased}
.s{width:1080px;height:1350px;position:relative;overflow:hidden;background:#f6f3ee;color:#141414;padding:110px 90px 0}
.s.dark{background:#141414;color:#fff}.s.red{background:#d90a0a;color:#fff}
.kick{display:inline-block;font:800 28px/1 'Inter';letter-spacing:.16em;text-transform:uppercase;color:#d90a0a;margin-bottom:28px}
.dark .kick{color:#ff4d4d}.red .kick{color:#ffd2d2}
h1{font:900 112px/.95 'Inter Display','Inter';letter-spacing:-.03em;text-transform:uppercase}
h2{font:900 88px/.98 'Inter Display','Inter';letter-spacing:-.025em;text-transform:uppercase;margin-bottom:44px}
h1 em,h2 em{font-style:normal;color:#d90a0a}.dark h1 em,.dark h2 em{color:#ff3b3b}.red h1 em,.red h2 em{color:#ffd2d2}
.big{font:900 220px/.9 'Inter Display','Inter';letter-spacing:-.04em;color:#d90a0a}
.dark .big{color:#ff3b3b}.red .big{color:#fff}
p.lead{font:500 42px/1.3 'Inter';color:#444;max-width:900px}
.dark p.lead{color:#d6d6d6}.red p.lead{color:#fff}
p.lead b{font-weight:800}
.row{display:flex;align-items:center;gap:30px;padding:28px 0;border-bottom:3px solid #e2ddd5;font:700 42px/1.15 'Inter'}
.dark .row{border-color:#333}.red .row{border-color:rgba(255,255,255,.3)}
.row:last-of-type{border-bottom:none}
.row small{display:block;font:500 30px/1.3 'Inter';color:#6b6b6b;margin-top:6px}
.dark .row small{color:#a5a5a5}.red .row small{color:#ffe1e1}
.ic{flex:0 0 84px;height:84px;border-radius:24px;display:grid;place-items:center;font:900 42px/1 'Inter';color:#fff;background:#d90a0a}
.ic.ok{background:#16a34a}.ic.no{background:#9ca3af}.ic.k{background:#141414}
.dark .ic.k{background:#fff;color:#141414}.red .ic{background:#fff;color:#d90a0a}
.foot{position:absolute;left:90px;right:90px;bottom:60px;display:flex;justify-content:space-between;align-items:center;font:700 28px/1 'Inter';color:#8a8a8a}
.dark .foot,.red .foot{color:rgba(255,255,255,.6)}
.foot b{color:#d90a0a;font-weight:900}.dark .foot b,.red .foot b{color:#fff}
.dots{display:flex;gap:10px}.dots i{width:14px;height:14px;border-radius:50%;background:#d7d0c6}.dots i.on{background:#d90a0a;width:40px;border-radius:8px}
.dark .dots i{background:#3a3a3a}.dark .dots i.on{background:#ff3b3b}.red .dots i{background:rgba(255,255,255,.35)}.red .dots i.on{background:#fff}
.chip{display:inline-block;font:800 34px/1 'Inter';padding:20px 30px;border-radius:50px;background:#fff;color:#141414;margin:0 14px 16px 0}
.s:not(.dark):not(.red) .chip{background:#141414;color:#fff}
.swipe{position:absolute;right:90px;bottom:150px;font:900 46px/1 'Inter'}
.swipe span{color:#d90a0a}.dark .swipe span{color:#ff3b3b}
.note{font:500 30px/1.35 'Inter';color:#777;margin-top:30px}
.dark .note{color:#9a9a9a}.red .note{color:#ffe1e1}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.card{background:#fff;border-radius:30px;padding:32px 32px;box-shadow:0 6px 0 #e2ddd5;color:#141414}
.dark .card{background:#232323;box-shadow:none;color:#fff}
.card b{display:block;font:900 40px/1.1 'Inter';margin-bottom:8px}
.card span{font:500 30px/1.3 'Inter';color:#666}.dark .card span{color:#aaa}
.stamp{position:absolute;right:50px;bottom:170px;transform:rotate(-10deg);border:8px solid #ff3b3b;color:#ff3b3b;font:900 58px/1 'Inter';padding:22px 40px;border-radius:24px;letter-spacing:.04em}
.vs{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.vs .col{border-radius:30px;padding:34px 30px;background:#fff;box-shadow:0 6px 0 #e2ddd5}
.dark .vs .col{background:#232323;box-shadow:none}
.vs .col h3{font:900 46px/1 'Inter';text-transform:uppercase;margin-bottom:20px}
.vs .col p{font:600 32px/1.3 'Inter';padding:12px 0;border-top:2px solid #eee}
.dark .vs .col p{border-color:#333}
.cta{font:800 52px/1.15 'Inter';margin-top:44px}
.cta em{font-style:normal;color:#d90a0a}.dark .cta em{color:#ff3b3b}
.src{position:absolute;left:90px;right:90px;bottom:120px;font:500 23px/1.35 'Inter';color:#8a8a8a}
.dark .src{color:#8f8f8f}
.huge{position:absolute;left:90px;bottom:170px;display:flex;align-items:flex-end;gap:28px}
.huge span{font:900 300px/.8 'Inter Display','Inter'}
.huge i{font:800 44px/1.15 'Inter';font-style:normal;padding-bottom:16px}
"""


def rich(s):
    """Escape text but allow *word* -> <em>word</em> and **b** -> <b>b</b>, and \n -> <br>."""
    s = E(s or "")
    import re
    s = re.sub(r"\*\*(.+?)\*\*", r"<b>\1</b>", s)
    s = re.sub(r"\*(.+?)\*", r"<em>\1</em>", s)
    return s.replace("\n", "<br>")


def rows_html(rows):
    out = []
    for r in rows or []:
        cls = {"ok": "ok", "no": "no", "k": "k", "red": ""}.get(r.get("style", ""), r.get("style", ""))
        sub = f"<small>{rich(r['sub'])}</small>" if r.get("sub") else ""
        out.append(f'<div class="row"><div class="ic {cls}">{E(r.get("icon", "•"))}</div><div>{rich(r["text"])}{sub}</div></div>')
    return "".join(out)


def slide_html(sl, i, n):
    theme = sl.get("theme", "light")
    t = sl["type"]
    kick = f'<span class="kick">{rich(sl.get("kick", ""))}</span>' if sl.get("kick") else ""
    body = ""
    if t == "cover":
        chips = "".join(f'<span class="chip">{E(c)}</span>' for c in sl.get("chips", []))
        body = (f'{kick}<h1>{rich(sl["title"])}</h1>'
                f'<p class="lead" style="margin-top:44px;max-width:760px">{rich(sl.get("lead", ""))}</p>'
                f'<div style="margin-top:56px;max-width:900px">{chips}</div>'
                f'<div class="swipe">Swipe <span>→</span></div>')
    elif t == "bignum":
        body = (f'{kick}<div class="big">{rich(sl["big"])}</div>'
                f'<p class="lead" style="margin:26px 0 36px">{rich(sl.get("lead", ""))}</p>{rows_html(sl.get("rows"))}')
    elif t == "list":
        body = f'{kick}<h2>{rich(sl["title"])}</h2>{rows_html(sl.get("rows"))}'
    elif t == "grid":
        cards = "".join(f'<div class="card"><b>{rich(c["title"])}</b><span>{rich(c.get("sub", ""))}</span></div>' for c in sl.get("cards", []))
        body = f'{kick}<h2>{rich(sl["title"])}</h2><div class="grid2">{cards}</div>'
    elif t == "vs":
        cols = ""
        for c in sl.get("cols", [])[:2]:
            ps = "".join(f"<p>{rich(p)}</p>" for p in c.get("points", []))
            cols += f'<div class="col"><h3 style="color:{E(c.get("color", "#d90a0a"))}">{rich(c["title"])}</h3>{ps}</div>'
        body = f'{kick}<h2>{rich(sl["title"])}</h2><div class="vs">{cols}</div>'
    elif t == "statement":
        huge = ""
        if sl.get("huge"):
            huge = f'<div class="huge"><span>{E(sl["huge"])}</span><i>{rich(sl.get("huge_label", ""))}</i></div>'
        body = f'{kick}<h2 style="font-size:{int(sl.get("size", 96))}px">{rich(sl["title"])}</h2><p class="lead">{rich(sl.get("lead", ""))}</p>{huge}'
    elif t == "cta":
        body = (f'{kick}<h2>{rich(sl["title"])}</h2>{rows_html(sl.get("rows"))}'
                f'<p class="cta">{rich(sl.get("cta", ""))}</p>')
    else:
        raise SystemExit(f"unknown slide type {t}")
    if sl.get("note"):
        body += f'<p class="note">{rich(sl["note"])}</p>'
    if sl.get("stamp"):
        body += f'<div class="stamp">{E(sl["stamp"])}</div>'
    if sl.get("sources"):
        body += f'<p class="src">Sources: {E("; ".join(sl["sources"]))}. General information, not legal or financial advice.</p>'
    dots = "".join(f'<i class="{"on" if k == i else ""}"></i>' for k in range(n))
    brand = "LAND ISTANBUL · landistanbul.com" if i == n - 1 else "LAND ISTANBUL"
    return f'<section class="s {E(theme)}" id="s{i+1}">{body}<div class="foot"><b>{brand}</b><div class="dots">{dots}</div></div></section>'


async def shoot(html_path, out_dir, n):
    from playwright.async_api import async_playwright
    async with async_playwright() as p:
        b = await p.chromium.launch()
        pg = await b.new_page(viewport={"width": 1080, "height": 1350})
        await pg.goto("file://" + html_path)
        await pg.evaluate("document.fonts.ready")
        overflow = await pg.evaluate("""() => [...document.querySelectorAll('section')].map(s => {
            const foot = s.querySelector('.foot').getBoundingClientRect().top;
            let maxB = 0; s.querySelectorAll(':scope > *:not(.foot):not(.src):not(.stamp):not(.swipe):not(.huge)').forEach(e => {maxB = Math.max(maxB, e.getBoundingClientRect().bottom)});
            const src = s.querySelector('.src'); const lim = src ? src.getBoundingClientRect().top : foot;
            return maxB > lim - 10 ? s.id : null }).filter(Boolean)""")
        for i in range(1, n + 1):
            el = await pg.query_selector(f"#s{i}")
            await el.screenshot(path=os.path.join(out_dir, f"slide{i}.png"))
        await b.close()
        return overflow


def build_short(spec, work, slug, voice):
    from PIL import Image, ImageDraw
    n = len(spec["slides"])
    dur = float(subprocess.check_output(["ffprobe", "-v", "error", "-show_entries", "format=duration", "-of", "csv=p=0", voice]))
    says = [s.get("say", "") or " " for s in spec["slides"]]
    tot = sum(max(len(x), 8) for x in says)
    lens = [dur * max(len(x), 8) / tot for x in says]
    for i in range(n):
        bg = Image.new("RGB", (1080, 1920), (20, 20, 20))
        bg.paste(Image.open(os.path.join(work, f"slide{i+1}.png")).convert("RGB"), (0, 285))
        d = ImageDraw.Draw(bg)
        w = (960 - (n - 1) * 14) / n
        for k in range(n):
            x0 = 60 + k * (w + 14)
            d.rounded_rectangle([x0, 1690, x0 + w, 1700], radius=5, fill=(255, 59, 59) if k <= i else (70, 70, 70))
        bg.save(os.path.join(work, f"v{i+1}.png"))
    X = 0.25
    inputs, filt, prev, off = [], [], "0:v", 0.0
    for i in range(n):
        L = lens[i] + (X if i < n - 1 else 0)
        inputs += ["-loop", "1", "-t", f"{L:.3f}", "-i", os.path.join(work, f"v{i+1}.png")]
    for i in range(1, n):
        off += lens[i - 1]
        filt.append(f"[{prev}][{i}:v]xfade=transition=slideleft:duration={X}:offset={off:.3f}[x{i}]")
        prev = f"x{i}"
    fc = ";".join(filt) + f";[{prev}]format=yuv420p,fps=30[v]" if filt else "[0:v]format=yuv420p,fps=30[v]"
    out = os.path.join(ROOT, "media", f"{slug}-short.mp4")
    subprocess.run(["ffmpeg", "-y", "-v", "error"] + inputs + ["-i", voice, "-filter_complex", fc, "-map", "[v]", "-map", f"{n}:a",
                    "-c:v", "libx264", "-preset", "veryfast", "-crf", "18", "-c:a", "aac", "-b:a", "192k", "-shortest",
                    "-movflags", "+faststart", out], check=True)
    return out


def main():
    spec_path = sys.argv[1]
    spec = json.load(open(spec_path))
    slug = spec["slug"]
    n = len(spec["slides"])
    if not 5 <= n <= 10:
        raise SystemExit("use 5-10 slides")
    work = os.path.join(ROOT, "build", "social", slug)
    os.makedirs(work, exist_ok=True)
    doc = "<!doctype html><html lang='en'><head><meta charset='utf-8'><style>" + CSS + "</style></head><body>" + \
          "".join(slide_html(s, i, n) for i, s in enumerate(spec["slides"])) + "</body></html>"
    hp = os.path.join(work, "slides.html")
    open(hp, "w").write(doc)
    overflow = asyncio.run(shoot(hp, work, n))
    if overflow:
        print("WARNING: text overflows the footer on", overflow, "- shorten those slides and rebuild")
    from PIL import Image
    os.makedirs(os.path.join(ROOT, "media"), exist_ok=True)
    for i in range(1, n + 1):
        Image.open(os.path.join(work, f"slide{i}.png")).convert("RGB").save(os.path.join(ROOT, "media", f"{slug}-{i}.jpg"), quality=92)
    print("slides:", n, "->", f"media/{slug}-1..{n}.jpg", "| preview PNGs in", work)
    if "--short" in sys.argv:
        voice = sys.argv[sys.argv.index("--short") + 1]
        print("short:", build_short(spec, work, slug, voice))


if __name__ == "__main__":
    main()
