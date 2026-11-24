#!/usr/bin/env python3
"""
Checks every post before it is pushed. Exit code 1 on errors.

    python3 tools/validate.py            # all posts
    python3 tools/validate.py posts/x.json
"""
import json
import re
import subprocess
import sys
from html.parser import HTMLParser
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
LANGS = ["en", "ar", "ru"]
SEGMENTS = {"sell", "citizenship", "apartment", "land", "general"}
VOID = {"img", "br", "hr", "input", "meta", "link", "source", "wbr"}


class TagChecker(HTMLParser):
    def __init__(self):
        super().__init__()
        self.stack, self.errors = [], []

    def handle_starttag(self, tag, attrs):
        if tag not in VOID:
            self.stack.append(tag)
        if tag == "img":
            a = dict(attrs)
            if not a.get("alt"):
                self.errors.append("img without alt")
        if tag in ("script", "iframe", "style"):
            self.errors.append(f"<{tag}> not allowed in body_html")

    def handle_endtag(self, tag):
        if tag in VOID:
            return
        if not self.stack or self.stack[-1] != tag:
            self.errors.append(f"unbalanced </{tag}> (open: {self.stack[-3:]})")
            if tag in self.stack:
                while self.stack and self.stack.pop() != tag:
                    pass
        else:
            self.stack.pop()


def check(path, all_slugs):
    errs, warns = [], []
    d = json.loads(path.read_text(encoding="utf-8"))
    for k in ("group", "segment", "published", "translations", "sources"):
        if k not in d:
            errs.append(f"missing {k}")
    if d.get("segment") not in SEGMENTS:
        errs.append(f"segment must be one of {sorted(SEGMENTS)}")
    if not re.fullmatch(r"\d{4}-\d{2}-\d{2}", d.get("published", "")):
        errs.append("published must be YYYY-MM-DD")
    if len(d.get("sources", [])) < 3:
        warns.append("fewer than 3 sources")
    for lang in LANGS:
        t = d.get("translations", {}).get(lang)
        if not t:
            errs.append(f"[{lang}] missing translation")
            continue
        p = f"[{lang}]"
        slug = t.get("slug", "")
        if not re.fullmatch(r"[a-z0-9]+(?:-[a-z0-9]+)*", slug):
            errs.append(f"{p} bad slug")
        key = (lang, slug)
        if key in all_slugs and all_slugs[key] != path.name:
            errs.append(f"{p} slug already used in {all_slugs[key]}")
        all_slugs[key] = path.name
        for k in ("title", "seo_title", "description", "excerpt", "body_html", "image_alt"):
            if not t.get(k):
                errs.append(f"{p} missing {k}")
        if len(t.get("seo_title", "")) > 70:
            warns.append(f"{p} seo_title is {len(t['seo_title'])} chars (aim <= 60)")
        dl = len(t.get("description", ""))
        if not 110 <= dl <= 170:
            warns.append(f"{p} description is {dl} chars (aim 140-160)")
        body = t.get("body_html", "")
        if body.count("<h2") < 4:
            errs.append(f"{p} needs at least 4 <h2> sections")
        if "<!--CTA-->" not in body:
            errs.append(f"{p} missing <!--CTA--> marker")
        words = len(re.sub(r"<[^>]+>", " ", body).split())
        if words < (900 if lang == "en" else 700):
            warns.append(f"{p} body only {words} words")
        tc = TagChecker()
        tc.feed(body)
        if tc.stack:
            errs.append(f"{p} unclosed tags: {tc.stack}")
        errs += [f"{p} {e}" for e in tc.errors]
        for src in re.findall(r'src="(/blog-images/auto/[^"]+)"', body):
            if not (ROOT / "images" / Path(src).name).exists():
                errs.append(f"{p} image not found in images/: {Path(src).name}")
        if len(t.get("faq", [])) < 4:
            warns.append(f"{p} fewer than 4 FAQ items")
    for kind in ("images", "og_images"):
        for lang in LANGS:
            rel = d.get(kind, {}).get(lang)
            if not rel or not (ROOT / rel).exists():
                errs.append(f"{kind}[{lang}] missing (run tools/make_cover.py)")
    return errs, warns


def main():
    files = [Path(a) for a in sys.argv[1:]] or sorted((ROOT / "posts").glob("*.json"))
    all_slugs = {}
    for f in sorted((ROOT / "posts").glob("*.json")):
        if f.resolve() not in [x.resolve() for x in files]:
            try:
                d = json.loads(f.read_text(encoding="utf-8"))
                for lang, t in d.get("translations", {}).items():
                    all_slugs[(lang, t.get("slug"))] = f.name
            except Exception:
                pass
    bad = False
    for f in files:
        errs, warns = check(f, all_slugs)
        print(f"{f.name}: {len(errs)} error(s), {len(warns)} warning(s)")
        for e in errs:
            print("  ERROR", e)
        for w in warns:
            print("  warn ", w)
        bad = bad or bool(errs)
    for php in (ROOT / "system").glob("*.php"):
        r = subprocess.run(["php", "-l", str(php)], capture_output=True, text=True)
        if r.returncode != 0:
            print("  ERROR php lint", php.name, r.stdout.strip())
            bad = True
    sys.exit(1 if bad else 0)


if __name__ == "__main__":
    main()
