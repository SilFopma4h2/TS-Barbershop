# Prijsadvies website Barbershop Oosterbeek

Vraag aan de council: hoeveel moeten Sil en Twan de klant vragen voor de site? Vier perspectieven (Opus), gebaseerd op de repo. Alle bedragen zijn schattingen; uren, budget van de klant en KvK/KOR-status zijn onbekend.

## Overzicht

| Perspectief | Eenmalig | Onderhoud p/m | Confidence |
|---|---|---|---|
| Strategist | €950 (€750–€1.200), incl. livezetten | €25–€35 | Medium |
| Advocate | ~€850 (€750–€1.000) excl. btw | €25–€40 | Medium |
| Skeptic | ~€600 (€450–€750), alleen met schriftelijke afspraak | €15–€25 | Medium |
| Innovator | €750 anker (€500–€750), of ~€450 + knipbeurten | €30 (min. 12 maanden) | Medium |
| **Synthese** | **€750 excl. btw, ondergrens €600** | **€25, max. 1 uur wijzigingen** | Medium |

## Strategist: "Prijs laag, verdien aan het onderhoud"
- Vast bedrag €950 (€750–€1.200) inclusief livezetten, plus €25–€35 per maand onderhoud, los van hosting.
- Aannames: 20–25 uur à €35–€45 (studenttarief). Een agency vraagt €75–€100 per uur.
- De repo is klein: 46 bestanden, ~1.300 regels code. Wel echte functies: Customizer "Barbershop gegevens", contactformulier, Salon Booking System-koppeling (`tsb_sync_services`), galerij met lightbox, productdialogen.
- Alle 6 commits staan op 2026-10-16 tussen 15:34 en 16:40. Dat begrenst wat een eerlijke prijs is.
- Hosting, domein/DNS, SSL, backups en livezetten zijn nog niet gedaan. Reken ze in de prijs, met één feedbackronde. Extra rondes per uur.
- Over 6 maanden: updates van WordPress en de plugin kunnen de koppeling breken (`functions.php:222-233`). €30 per maand dekt updates, backups, kleine tekstwijzigingen en een kwartaalcheck van de boeking.
- Risico: te laag (€400) legt het anker voor alle volgende klussen. Boven ~€1.500 concurreer je met agencies. Spreek het onderhoud af vóór livegang.
- Vraag: "Wat maakt dit later makkelijker of moeilijker?" Zonder onderhoudscontract zijn jullie de gratis helpdesk bij de eerste kapotte pluginupdate.

## Advocate: "Prijs wat de eigenaar echt krijgt"
- €750–€1.000 eenmalig, richt ~€850 excl. btw, plus €25–€40 per maand voor hosting, updates en kleine wijzigingen.
- Daarvoor krijgt de klant: hosting, site live op zijn domein, een uur uitleg ter plekke, een Nederlandstalig spiekbriefje en 30 dagen gratis fixes.
- Onder €600 verkoop je de boeking te goedkoop. Boven €1.200 voelt het als agency-geld.
- Waarde voor de eigenaar: online boeken met voorgekozen behandeling (`tsb_afspraak_url`), zelf adres, tijden en prijzen aanpassen, "Nu open"-badge (`feedback.js`), vertrouwde oude kleuren, contactformulier met nonce en honeypot.
- Problemen voor de eigenaar:
  1. Prijzen staan op twee plekken (Customizer en Salon Booking), dus ze lopen uit elkaar.
  2. Reviews staan hard-coded in `front-page.php`.
  3. De galerijmap `assets/img/galerij/` is leeg en vraagt FTP. Zet het Galerij-blok als standaard.
  4. Nog niet live: hosting, domein, SSL, mail (`wp_mail`), openingstijden in de plugin, permalinks (README stap 4–8).
  5. De echte kosten zijn support. Leg schriftelijk vast wat wel en niet inbegrepen is.
- Vraag: "Wat gebeurt er de eerste keer dat de eigenaar zelf een prijs of foto wil wijzigen?"

## Skeptic: "Prijs op de uren en dek de risico's af"
- €450–€750 eenmalig (anker ~€600), alleen met een A4-afspraak over scope, revisierondes en overdracht. Onderhoud optioneel, €15–€25 per maand. Wil de klant niets tekenen: lager prijzen en het werk afkappen, niet hoger prijzen met open aansprakelijkheid.
- Aannames: 20–30 uur à €20–€30; hosting en domein betaalt de klant zelf.
- Het thema is klein en snel gebouwd (~970 regels, 6 commits in één middag). Escaping is consistent, het formulier is veilig (`functions.php:104-133`).
- Kwetsbaar:
  - Koppeling met Salon Booking System via interne post-meta (`_sln_service_price`, `salon_settings`, `functions.php:204-233`). Zonder plugin toont `/afspraak/` alleen "agenda is nog niet actief" (`page-afspraak.php:44`).
  - Prijzen dubbel opgeslagen (`functions.php:46` en `154-159`).
  - Facebook-standaard `facebook.com/robertskapsalon/` (`functions.php:44`): klopt dat met de klant?
- Risico's die de offerte negeert:
  1. AVG: Google Fonts van Google-servers (`functions.php:23`), geen privacypagina of cookietekst, terwijl formulier en plugin persoonsgegevens verzamelen.
  2. Beeldrechten: productfoto's (`assets/img/product-*.png`) en gekopieerde Google-reviews (`front-page.php:7-12`).
  3. Mail zonder SMTP belandt vaak in spam.
  4. Geen SEO (meta description, Open Graph, LocalBusiness-schema).
  5. Premium pluginfuncties (sms, betalingen, Google Agenda) kosten extra.
  6. Belasting: zonder KvK is het "resultaat uit overige werkzaamheden"; check KOR vóór btw rekenen; spreek de verdeling tussen twee personen af.
  7. Geen einde aan de garantie.
- In de offerte opnemen: fonts lokaal, privacypagina, SMTP, prijzen op één plek, 2 revisierondes, 30 dagen bugfixgarantie, daarna per uur.
- Vraag: "Als Salon Booking System update en de agenda zaterdagochtend kapot is, wie krijgt de telefoon en zit dat in het onderhoud?"

## Innovator: "Prijs de zorg, niet het thema"
- Bouwbedrag €500–€750 (quote €750), plus €30 per maand voor hosting, updates en kleine wijzigingen, minimaal 12 maanden. Eerste jaar ongeveer €1.100. Een agency vraagt €1.500–€3.000+.
- Het thema is klein (~970 regels). Tegen €40 per uur kom je op €400–€600, dat is te weinig voor wat de klant krijgt.
- De waarde zit in de koppeling (`tsb_sync_services()`, voorgekozen dienst op `/afspraak/`) en in het zelf kunnen aanpassen via de Customizer.
- De annuleringstekst (`functions.php` regel 48) suggereert dat de oude site al online boeken had. Prijzen op "boekingen die de site oplevert" of omzetdeling is daarom zwak: niet te bewijzen en een kapper accepteert geen cut per knipbeurt. Deze optie is laten vallen.
- Ankers: Wix/Squarespace met boekingsadd-on of Salonized/Treatwell kost ~€25–€60 per maand.
- Onconventioneel: prijs in knipbeurten. €750 is ~37 herenknipbeurten à €20. Hybride: ~€450 contant, een jaar gratis knippen voor beiden, een "website door Sil & Twan"-link in de voet en toestemming om de site als case te gebruiken.
- Omkering: vraag nu €500 en laat de klant na 3 maanden aan de hand van zijn boekingscijfers kiezen of hij het onderhoud wil.
- Risico's: een retainer maakt jullie verantwoordelijk voor updates en uptime (spreek een maandplafond af, bijvoorbeeld 1 uur); ruil is ook inkomen voor de belasting (KvK, btw/KOR); een lage eerste prijs wordt de referentie (toon de eerstekliantkorting als aparte regel); de plugin is een afhankelijkheid.
- Vraag: "Welke beperking accepteert iedereen zonder vragen?" Dat de betaling een eenmalig geldbedrag voor een af product moet zijn.

## Synthese
Vraag **€750 eenmalig excl. btw** (ondergrens €600) plus **€25 per maand** onderhoud, alleen met een A4-afspraak (scope, 2 feedbackrondes, 30 dagen garantie).

Onopgeloste keuzes:
- Contant of deels in natura (Innovator). Laag vertrouwen; belasting nog uitzoeken.
- Verdeling tussen Sil en Twan, en KvK/KOR-status: alleen jullie kunnen dit bepalen.

Blinde vlekken: echte uren, budget van de klant, wat de oude site kost, of de oude site al online boeken had.

## Volgende stappen
1. Verdeling en KvK/KOR-status afspreken.
2. Afspraak van één pagina opstellen (scope, 2 rondes, 30 dagen garantie, hosting op naam van de klant, onderhoud optioneel).
3. Vóór oplevering repareren: prijzen op één plek, Google Fonts lokaal, privacypagina, SMTP, galerij via het Galerij-blok.
4. Schriftelijk toestemming vragen voor foto's en reviews; Facebook-link controleren.
5. Na 3 maanden de boekingscijfers met de klant bespreken en het onderhoud herzien.
