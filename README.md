# landistanbul-blog

Publishing source for the multilingual (English / Arabic / Russian) blog of **landistanbul.com**.
Every push is pulled by Hostinger into `public_html/autoblog/`, and `system/install.php` turns the posts into
static, SEO-ready pages under `/blog/`, `/blog/ar/` and `/blog/ru/`. Nothing in this folder is served directly
(`.htaccess` denies access); only the generated pages and copied images are public.

## Layout

| Path | What it is |
| --- | --- |
| `posts/YYYY-MM-DD-<slug>.json` | One article in three languages (`translations.en/ar/ru`), FAQ, sources, segment |
| `images/` | Hero illustration, social images per language, in-article infographics |
| `system/generator.php` | Page generator (installed to `admin/includes/generator.php`; the admin panel keeps working) |
| `system/mail.php` | Lead form handler: emails info@landistanbul.com and saves to `/_private/leads.jsonl` |
| `system/blog-extra.css`, `system/blog-lead.js` | Styles and lead-form script for articles |
| `system/install.php` | Runs after each pull (Composer hook); backs up originals to `/_private/backups/` |
| `tools/make_cover.py` | Draws the hero + social images for a post |
| `tools/make_infographic.py` | Draws in-article infographics (steps / key facts) |
| `tools/validate.py` | Checks posts and PHP before pushing |
| `plan/topics.md` | Editorial queue across the four lead segments |
| `AUTOPILOT.md` | The daily routine |

## Segments (lead types)

`sell` property owners who want to sell · `citizenship` Turkish citizenship by investment ·
`apartment` apartment buyers · `land` land buyers · `general`.
The segment picks the call-to-action, the pre-selected interest in the lead form and the category label.

## Undo

Original files are in `/_private/backups/` on the server (`generator.php.orig`, `mail.php.orig`, `sitemap.xml.orig`,
`blog-index.html.orig`). Removing a post file from `posts/` and pushing removes its pages.
