# Daily autopilot — one new article a day for landistanbul.com

Goal of every article: **bring leads** — property owners who want to sell, Turkish-citizenship investors,
apartment buyers and land buyers — by ranking in Google for what they search and converting them with the
segment's lead form and WhatsApp button. Quality beats volume: one excellent, accurate article per day.

Hostinger: username `u786344181`, domain `landistanbul.com`. Repo on the server: `public_html/autoblog`.

## 1. Start

1. Clone or update the repo (`/home/claude/landistanbul-blog`), `git pull`.
2. Read `public_html/_private/autoblog-status.json` with the Hostinger connector (`hosting_files_website-content`).
   If `ok` is false or `errors` is not empty, fix that first.
3. Look at the latest files in `posts/` (titles, segments) and `plan/topics.md`.

## 2. Pick today's topic

- Rotate segments (`sell`, `citizenship`, `apartment`, `land`): never the same segment as the previous post;
  keep them balanced over the week.
- Check the news first (WebSearch, a few queries such as: Türkiye yabancı gayrimenkul yeni düzenleme, tapu harcı,
  Resmi Gazete yabancıya konut satışı, Turkish citizenship by investment news, Istanbul property prices foreigners,
  TÜİK yabancılara konut satışı). A real, recent change that affects buyers or sellers beats the queue.
- Otherwise take the next open topic in `plan/topics.md` that fits the rotation. Never repeat a published topic.
- Choose ONE primary search phrase (English) and its natural Arabic and Russian equivalents.

## 3. Research (no invented facts)

- 6–12 searches; open (WebFetch) the pages you take facts from. Prefer official sources: resmigazete.gov.tr,
  tkgm.gov.tr, goc.gov.tr, gib.gov.tr, nvi.gov.tr, invest.gov.tr, tuik.gov.tr, tcmb.gov.tr, ticaret.gov.tr; then law
  firms and major outlets. Note the date of every figure. Conflicting sources → say so or use the official one.
- Never invent prices, yields, statistics, client stories or testimonials. If a number cannot be sourced, leave it out.
- Keep 3–6 sources for the `sources` list (title + URL).

## 4. Write the post JSON

Copy the structure of `posts/2026-11-24-turkish-citizenship-by-investment-2026.json` into
`posts/<YYYY-MM-DD>-<slug>.json` (build it with a small Python script so escaping is safe).

- `group` = `slug` = English kebab-case of the primary phrase (same slug in all three languages).
- `segment`, `published` = today (Europe/Istanbul), `updated` = today, `sources`.
- English body 1,400–2,200 words; Arabic and Russian are complete, native-quality versions (not word-for-word):
  localized keywords in title, first paragraph, one H2 and the description; Russian quotes «…»; Arabic punctuation.
- `title` contains the primary phrase; `seo_title` ≤ 60 chars; `og_title` ≤ 70 chars; `description` 140–160 chars;
  `excerpt` 2–3 sentences that promise the answer; `image_alt` describes the illustration; `keywords` 4–6.
- `body_html`: 5–8 `<h2>` sections that answer the searcher's real questions in order; first section answers the
  query directly; at least one table (`<div class="li-table-wrap"><table>…`) or numbered steps (`<ol class="li-steps">`);
  one infographic `<figure><img src="/blog-images/auto/<group>-<name>-<lang>.jpg" alt="…" loading="lazy" width="1200"></figure>`;
  `<!--CTA-->` after the second section; 2+ internal links (other posts under `/blog/...`, `/tax-calculator/`);
  a closing "How Land Istanbul helps" section (soft, concrete, no promises of outcomes).
  Allowed tags: h2 h3 p ul ol li strong em a table thead tbody tr th td div(li-table-wrap) blockquote figure img aside(li-note).
- `faq`: 5–7 real search questions with short, direct answers (they become FAQ rich results).
- `infographics`: one `steps` or `facts` spec with texts in all three languages.
- Tone: expert, specific, honest, calm. Dates explicit ("as of November 2026"). No hype, no guarantees,
  no "best agency" claims, no fake urgency. Legal/tax points: say when to confirm with a professional.

## 5. Images and checks

```
python3 tools/make_infographic.py posts/<file>.json
python3 tools/make_cover.py posts/<file>.json
python3 tools/validate.py posts/<file>.json      # must end with 0 errors
```
**Every post must have a different cover (owner's rule).** `make_cover.py` picks an illustration style that fits the
topic and that none of the last 4 posts used (passport, facade, isometric, aerial_land, chart, window, coast, keys,
skyline), with a palette never used before with that style, and stores it as `"cover"` in the post JSON.
`validate.py` fails if the style/palette pair was used before or the style matches one of the 2 previous posts.
To change it: `python3 tools/make_cover.py posts/<file>.json --style coast --palette teal` (styles and palettes are
listed in `tools/scenes.py`). New styles can be added to `tools/scenes.py` (register them in `STYLES` and in
`SEGMENT_STYLES` / `KEYWORD_STYLES` in `make_cover.py`).
Look at the hero image and one infographic with the Read tool: it must look clearly different from the previous
post's cover, and each `image_alt` must describe what the cover actually shows. Mark the topic `[x]` with the date in `plan/topics.md` (add it if it came from the news).

## 6. Publish

1. `git add -A && git commit` ("Post: <English title>", plus the session's attribution lines) and
   `git -c push.negotiate=true push`.
2. Hostinger `hosting_git_deploy-website-repository` with
   `{"username":"u786344181","domain":"landistanbul.com","repository_url":"https://github.com/atalhaarvas-pixel/landistanbul-blog.git","branch":"main","directory":"autoblog"}`.
3. Read `_private/autoblog-status.json`: `commit` must equal the pushed HEAD, `ok` true, `errors` empty, and the new
   ids in `pages`. Read the first 20 lines of `blog/<slug>/index.html` to confirm the page exists.
4. If the status did not change, the Composer hook did not run: report it instead of retrying in a loop.

## 7. Tax calculator data (monthly / yearly)

`data/tax-data.json` feeds the tax calculator (`/tax-calculator/`, `/tax-calculator/ar/`, `/tax-calculator/ru/`,
built by `system/taxcalc.php` on every deploy). The calculator works in Turkish lira only (no exchange rates):
- **Monthly, after TÜİK publishes (around the 3rd):** add the previous month's Yİ-ÜFE (2003=100) to `yiufe`
  and set `updated`. Check at least two sources (e.g. TÜİK bulletin, hakedis.org, oska.com.tr).
- **Every January:** add the new year's annual exemption (`exemptions`) and the NON-WAGE income tax tariff
  (`brackets`, from the Gelir Vergisi Genel Tebliği) once published in the Resmî Gazete.
- Text of the calculator in three languages lives in `tc_t()` in `system/taxcalc.php`. The 2026 figures quoted in
  its FAQ (₺150,000, brackets) must be updated together with the data in January.

## 7b. Lead tools

- `/free-property-valuation/` (+ar/ru) from `system/valuation.php`; leads arrive with interest "Free property valuation".
- `/turkish-citizenship-eligibility/` (+ar/ru) from `system/eligibility.php`: 4-question quiz, then a form. Leads arrive
  with interest "Turkish citizenship by investment", "Residence permit by property", "Investor residence permit" or
  "Buying an apartment" and the answers in `details` (p_budget, p_buy, p_family, p_when, p_result).
  Thresholds used (Nov 2026): citizenship $400k property / $500k deposit-funds; residence by property $200k;
  investor residence (Decision 11994, 18 Nov 2026) $150k = 3 yrs, $200k = 5 yrs in deposits, bonds, REIT/VC fund
  units or private pension, held half the term. If any of these change, update the texts in `le_t()` the same day.
- Posts with segment `citizenship` or `apartment` link to the eligibility check from their lead box.

## 8. Leads

Form leads are emailed to info@landistanbul.com and saved, one JSON per line, in `_private/leads.jsonl`
(fields: received_at, name, email, phone, interest, budget, message, source, lang). Read it with the Hostinger
connector and report the new ones. Valuation requests have `interest` = "Free property valuation" and the property
details in `details` (city, district, type, rooms, size, age, features…). Never put lead data in this repository: it is public.
