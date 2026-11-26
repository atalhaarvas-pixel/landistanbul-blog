# Daily social autopilot — Land Istanbul (Instagram · TikTok · YouTube)

Goal: every day at **12:00 Istanbul** publish ONE informative, current, share-worthy post in **English** on
Instagram (carousel), TikTok (photo carousel) and YouTube (Short with voice-over), so that foreign buyers and
investors **trust** Land Istanbul and **contact** us (DM, WhatsApp +90 546 891 63 49, landistanbul.com forms).
Brand line: **Land Istanbul by Math Investment** · licensed broker, licence no. 3408945 · Beylikdüzü, Istanbul.

Accounts (Buffer organisation "My organization", id `6b06b9b200cbe49a8cdb39c9`):
- Instagram `mathinvestment` — channel `6b06bb3b8541f09ecb9b332f`
- TikTok `land.istanbul` — channel `6b06c4898541f09ecb9ba0bb`
- YouTube `LAND ISTANBUL` — channel `6b06c22f8541f09ecb9b8648`

## 1. Topic — stay on our subjects

Only topics a foreign buyer/investor in Türkiye (mainly Istanbul) cares about. Weekday pillar:

| Day | Pillar | Examples |
|---|---|---|
| Mon | **Market data** | latest TÜİK sales to foreigners (by country/city), price indices (TCMB KFE), mortgage/interest news |
| Tue | **Rules** | citizenship, residence permits ($150K investor permit, $200K property), title deed process, new Resmî Gazete decisions |
| Wed | **District spotlight** | Beylikdüzü, Başakşehir, Esenyurt, Büyükçekmece, Kağıthane, Kartal… (transport, who it suits, what to check) |
| Thu | **Costs & taxes** | title deed fee, valuation report, DASK, property tax, capital-gains tax (link our calculator), rental income tax |
| Fri | **Safety & myths** | scams, fake valuations, cash-backs, shared title (hisseli tapu), zoning, off-plan risks, "myth vs fact" |
| Sat | **Country guide** | buyers from the Gulf, Iraq, Pakistan, Germany, UK… (visa, dual citizenship, money transfer) — link our country pages |
| Sun | **Smart buyer** | land vs apartment, rent vs buy, checklist before viewing, how to buy from abroad, FAQ round-up |

A real, recent change (last ~14 days) beats the pillar: check news first (WebSearch, e.g. "Resmi Gazete yabancı
gayrimenkul", "yatırım yoluyla vatandaşlık yeni", "TÜİK yabancılara konut satışı", "Turkey property foreigners news").
Never repeat a topic or angle from `social/log.json` in the last 30 days.

## 2. Research — truth first (this is how we earn trust)

- 4–10 searches; WebFetch the pages you take numbers from. Prefer official sources (resmigazete.gov.tr, tuik.gov.tr,
  tkgm.gov.tr, goc.gov.tr, gib.gov.tr, icisleri.gov.tr, invest.gov.tr, tcmb.gov.tr), then major outlets / law firms.
- **Every number on a slide must be sourced and dated.** No invented prices, yields, "X% growth", rankings,
  testimonials, client stories, guarantees or "best agency" claims. If a figure can't be confirmed, drop it.
- Rules and taxes: state the condition precisely (e.g. "held 3 years", "spouse + children under 18").
- Last slide lists 1–3 short source names; the captions carry "Source: …".

## 3. Write the spec → `social/specs/<YYYY-MM-DD>-<slug>.json`

Copy `social/specs/EXAMPLE.json`. `slug` = short English kebab-case, unique (add the date if needed).
6–8 slides, English, very short text (a slide is read in 2–3 seconds):

1. `cover` (theme dark): scroll-stopping hook — a surprising true number, a question, or "X things nobody tells you".
   `title` ≤ 5 short lines; `*word*` = red highlight; 2–3 chips; lead = the promise.
2–6. one idea per slide: `bignum` (one big sourced number), `list` (3–5 rows), `grid` (4–6 cards), `vs` (two columns),
   `statement` (theme red, one bold line). Mix types; alternate light/dark; ≤ 5 rows; ≤ 45 characters per row title.
7. a practical "what to do / checklist" slide (this is what people save).
8. `cta` (theme dark): soft next step + "Save this 📌" + DM keyword (e.g. *DM us "PERMIT"*) + `sources`.

Each slide has `say`: 1–2 short spoken sentences for the YouTube voice-over (whole script 25–45 s, numbers written
as words, e.g. "four hundred thousand dollars").

Build and LOOK at it:
```
python3 tools/social/make_social.py social/specs/<file>.json
```
Open `build/social/<slug>/slide*.png` with Read. Fix any WARNING (text overflow), cramped or cut text, wrong facts,
typos. Rebuild until clean.

## 4. Voice-over + Short

Speko `audio_synthesize` (do not pin a voice/provider; ElevenLabs needs credit):
`{"text": <all "say" lines joined>, "intent": {"language": "en-GB", "optimizeFor": "accuracy"}, "speed": 1.15,
"instructions": "Energetic, clear social-media narrator. Fast pace, confident, short pauses. Same single voice."}`
Copy the WAV from the tool-result path, then:
```
ffmpeg -y -v error -i speech.wav -af "atempo=1.08,apad=pad_dur=0.8" -ar 48000 build/voice.wav
python3 tools/social/make_social.py social/specs/<file>.json --short build/voice.wav
```
If Speko fails, skip voice: `ffmpeg -f lavfi -i anullsrc=r=48000:cl=mono -t 30 build/voice.wav` and continue.
Check one frame of the MP4 (ffmpeg → PNG → Read). No music.

## 5. Publish the files

Add a line to `social/log.json` (date, slug, pillar, topic, hook, sources, post ids — filled after step 6),
then `git add media/<slug>-* social/ && git commit && git pull --rebase && git push`, then deploy with the Hostinger
connector `hosting_git_deploy-website-repository` (username `u786344181`, domain `landistanbul.com`,
repository `https://github.com/atalhaarvas-pixel/landistanbul-blog.git`, branch `main`, directory `autoblog`).
Confirm with `hosting_files_list-website-and-directories` (directory `media`) that the files exist.
Never commit leads, emails, phone numbers of people or anything private — the repo is public.

## 6. Schedule in Buffer — 12:00 Istanbul

`create_post`, `schedulingType: "automatic"`, `mode: "customScheduled"`, `dueAt: "<today>T12:00:00+03:00"`.
(If it is already after 11:50, use the next free quarter hour today, e.g. 12:15.)

- **Instagram**: assets = the N slide JPG URLs `https://landistanbul.com/media/<slug>-<i>.jpg` (each with altText),
  `metadata.instagram = {"type": "post", "shouldShareToFeed": true}`.
- **TikTok**: same images, `metadata.tiktok = {"title": <≤ 60 chars hook>}`.
- **YouTube**: asset = `https://landistanbul.com/media/<slug>-short.mp4`, `metadata.youtube = {"type": "short",
  "title": <hook ≤ 90 chars, ends with #Shorts>, "categoryId": "19", "privacy": "public", "madeForKids": false,
  "isAiGenerated": true, "notifySubscribers": true}`.

Captions (English, honest, viral but never clickbait-false):
- Line 1 = the hook (number/question + 1–2 emoji). Then 3–5 ✅/⚠️ bullet facts. Then "Save this 📌 / Send it to
  someone who…". Then the DM keyword CTA (YouTube: "Comment …" + landistanbul.com + a relevant page link).
  Then "Source: …". Then "General information, not legal advice." when it is about law/tax.
- Hashtags: Instagram 10–15, TikTok 5–8 (+ #fyp), YouTube 4–7 (+ #Shorts). Only relevant ones; mix broad
  (#Istanbul #MoveToTurkey #InvestInTurkey #ExpatLife #RealEstate) with niche (#TurkishCitizenship
  #TurkeyResidencePermit #IstanbulRealEstate #BuyPropertyInTurkey #SecondPassport…). Never unrelated trending tags.

Then `get_post` each post id once to confirm status `scheduled`; write the ids into `social/log.json` and push again.

## 7. Report

Short Turkish summary: topic, why it was chosen, the hook, sources, and the three scheduled post ids/times.
If something failed (Speko, deploy, Buffer), say exactly what and what was done instead.
Remind (only when relevant): YouTube "Altered content → Yes" must be set by hand in YouTube Studio.
