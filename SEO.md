# Afternoon SEO routine — make landistanbul.com rank (no new articles)

Since 28 Nov 2026 the afternoon run does NOT publish a new article (the morning run publishes one a day).
A young domain that publishes 6 new pages a day risks being crawled slowly or treated as mass-produced content.
The afternoon run makes existing pages stronger instead. Owner's goal: foreign buyers/sellers find us on Google
(EN/AR/RU) and contact us. Quality, accuracy and usefulness beat volume.

## What we know (Search Console export, 28 Nov 2026, last 3 months)
- 31 clicks, 30 of them from Türkiye, almost all for the brand ("land istanbul", avg position 6.8 — must become #1).
- Only 4 URLs had impressions: `/`, `/tax-calculator/` (991 impressions, 3 clicks, avg pos 23),
  `/blog/turkish-citizenship-by-investment-2026/` (12, pos 30), `/blog/turkey-residence-permit-150000-investor-2026/` (3, pos 8).
- All blog posts are from 24 Nov 2026 onwards, so they had no time to rank yet. Not a technical block:
  robots.txt allows all, pages are index,follow, canonicals and hreflang are correct, sitemap lists everything.
- "property tax calculator turkey" (505 impressions, pos ~10 in Sep–Oct, then dropped): answered by the new page
  `/turkey-property-tax-calculator/` (27 Nov). US "capital gains" queries are noise — ignore.
- If the owner drops new Search Console exports or screenshots, the main session records the new facts here.

## Each run: do 2–4 of these jobs (rotate; log what you did in `seo/log.md`)

1. **Refresh one article** (oldest first, or one that is out of date): re-check every number and rule against
   current official sources; fix anything outdated; add a missing question searchers ask; tighten the intro so the
   first 2 sentences answer the query; make sure title/seo_title/description contain the primary phrase.
   Set `updated` to today ONLY when the content really changed. Edit all three languages.
2. **Internal links**: every article links to 2–4 related articles (same topic cluster) and to the matching tool
   (valuation, eligibility, property tax calculator, capital gains calculator) with descriptive anchor text in the
   article's language. Add links from older posts to newer ones and back. No link stuffing.
3. **Tool pages** (`system/taxcalc.php`, `system/proptax.php`, `system/eligibility.php`): add a worked example,
   1–2 FAQ that real searchers ask, clearer intro text. Keep rates current (January: new tariffs, DKV threshold,
   TKGM fee; first days of each month: Yİ-ÜFE for the capital gains tool — see AUTOPILOT section 7).
4. **Topic clusters**: update `plan/topics.md` so the morning run fills gaps around our money pages
   (citizenship, residence permits, buying costs/taxes, selling, land, districts, country guides). Prefer
   long-tail questions foreigners really type ("can foreigners buy land in Turkey", "title deed fee Turkey 2026").
5. **Quality pass** on one article: remove filler, repeated sentences and generic AI phrasing; make sure each H2
   answers a real question; check Arabic and Russian read naturally (not word-for-word); check image alt texts.
6. **Technical check** (weekly, Mondays): sitemap has all live URLs; no page is missing a title, description,
   canonical or hreflang; no broken internal links (scan the generated HTML in a local mock run of the installer
   copy, never in the repo folder); page weight of images is reasonable.

## Never
- Never invent facts, prices, yields, statistics, reviews or client stories. Every figure has a dated source.
- Never create doorway pages, keyword-stuffed text, hidden text, fake dates (no `updated` bump without a real
  change), or links on other sites. Never delete posts or change slugs (URLs must stay stable).
- Never put lead data or private data in this public repo.

## Finish
Validate (`python3 tools/validate.py` → 0 errors), commit, push, deploy (Hostinger connector, directory
`autoblog`), check `_private/autoblog-status.json` (new commit, ok true, no errors), append to `seo/log.md`,
report in Turkish in 2–4 lines: what was improved and why.
