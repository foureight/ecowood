# Kompostárna ECOWOOD — web

Kompletní web kompostárny ECOWOOD (ecowood.cz).

## Struktura

```
ecowood/
  index.php, kompost.php, substraty.php, sluzby.php, kontakt.php, faq.php
  includes/     — header, footer, SEO, FAQ, geo bloky
  data/         — alerts.json, news.json, faq.json
  sitemap.xml, sitemap.html, robots.txt
```

## Lokální náhled

```bash
cd ecowood
php -S localhost:8080
# → http://localhost:8080/index.php
```

## SEO — co je implementováno

| Prvek | Soubor / stránka |
|-------|-------------------|
| Title, description, keywords | Každá stránka — proměnné `$page_*` |
| Canonical URL + hreflang | `includes/head.php` |
| Geo meta (GPS, region) | `includes/head.php` |
| Open Graph + Twitter Cards | `includes/head.php` |
| JSON-LD RecyclingCenter | Všechny stránky |
| JSON-LD FAQPage | Stránky s `$page_faq_tags` |
| JSON-LD Service | `sluzby.php` |
| JSON-LD BreadcrumbList | Podstránky |
| Otevírací doba vč. zimního provozu | `seo_opening_hours()` |
| Interní prolinkování | `includes/related-pages.php` |
| Geo obsah (Kladno, Praha) | `includes/geo-areas.php` |
| FAQ obsah | `data/faq.json` + `faq.php` |
| sitemap.xml | Kořen webu |
| robots.txt | Odkaz na sitemap |

## Po nasazení — checklist

1. [Google Search Console](https://search.google.com/search-console) — přidat `www.ecowood.cz`
2. Odeslat sitemap: `https://www.ecowood.cz/sitemap.xml`
3. [Rich Results Test](https://search.google.com/test/rich-results) — ověřit LocalBusiness + FAQ
4. Google Business Profile — stejná adresa a GPS jako na webu
5. Upravit `data/faq.json` a `data/news.json` dle aktuálního provozu

## Editace obsahu

- **FAQ:** `data/faq.json` (tagy: `kompost`, `substraty`, `sluzby`, `geo`, `kontakt`, `faq`)
- **Novinky:** `data/news.json`
- **Upozornění:** `data/alerts.json`

## Nasazení na ecowood.cz

Web je v PHP, takže ho nestačí někam zkopírovat — musí běžet na hostingu s PHP.
Ten už pro ecowood.cz máte, současný web na něm běží.

### 1. Zálohovat současný web

Přes FTP nebo správce souborů u hostingu si stáhněte obsah webového adresáře.
Bývá to `www/`, `public_html/` nebo `htdocs/`.

### 2. Nastavit klíč pro captchu

V `includes/captcha.php` změňte `EW_CAPTCHA_SECRET` na vlastní náhodný řetězec.
Bez toho by šel podpis kontrolní otázky padělat.

### 3. Zkontrolovat otevírací dobu

V `includes/seo-config.php` ve funkci `seo_opening_hours()` je letní i zimní
provoz. Řídí se podle nich pruh nahoře i údaje pro Google.

### 4. Nahrát soubory

Nahrajte **obsah** složky `ecowood/` (ne složku samotnou) do webového adresáře.
Nahrát je potřeba všechno kromě těchto dvou souborů, které slouží jen pro vývoj:

- `build-nahled.sh`
- `README.md`

Nezapomeňte na `.htaccess` — bývá skrytý, v FTP klientovi je nutné zapnout
zobrazování skrytých souborů. Zajišťuje přesměrování na HTTPS a `www`.

### 5. Nastavit odesílání e-mailů

Kontaktní formulář posílá poštu přes SMTP. Přístupové údaje se čtou
z proměnných prostředí, aby heslo neleželo v repozitáři:

| Proměnná | Význam |
|---|---|
| `EW_SMTP_HOST` | adresa SMTP serveru, např. `smtp.seznam.cz` |
| `EW_SMTP_PORT` | `587` pro STARTTLS, `465` pro SSL |
| `EW_SMTP_USER` | přihlašovací jméno, obvykle celá e-mailová adresa |
| `EW_SMTP_PASS` | heslo — zadávat **jen** jako secret proměnnou |
| `EW_SMTP_SECURE` | `tls` (výchozí) nebo `ssl` |
| `EW_MAIL_FROM` | odesílatel, výchozí je `EW_SMTP_USER` |
| `EW_MAIL_TO` | příjemce, výchozí `ecowood@ecowood.cz` |

Pokud `EW_SMTP_HOST` nastavený není, zkusí se funkce `mail()`. Na běžném
PHP hostingu tedy stačí nenastavovat nic.

### Pozor na port při provozu na Zerops

Zerops propouští ven pouze **port 587 se STARTTLS**. Porty 25 a 465 blokuje,
spojení na ně skončí vypršením časového limitu — v odpovědi formuláře se
objeví `Operation timed out`.

Server `smtp.cloudevelops.com` naslouchá jen na 465, takže tuto kombinaci
nelze na Zerops zprovoznit. Řešení je jedno z těchto:

1. požádat poskytovatele schránky o zpřístupnění portu 587 se STARTTLS
   a přepnout `EW_SMTP_PORT` na `587` a `EW_SMTP_SECURE` na `tls`,
2. požádat podporu Zerops o výjimku pro port 465,
3. použít poskytovatele, který 587 nabízí.

Na běžném PHP hostingu tohle omezení neplatí.

Na Zerops je vše kromě hesla v `zerops.yml`. Heslo přidejte ve službě
`phpapache` → Environment variables jako **secret** proměnnou `EW_SMTP_PASS`.

### 6. Ověřit

- Projít všech šest stránek
- Odeslat zkušební zprávu z kontaktního formuláře (potřebuje funkční `mail()`)
- Otevřít `https://www.ecowood.cz/sitemap.xml`

## Statický náhled k rozeslání

Pokud web potřebujete jen někomu ukázat, `./build-nahled.sh` vygeneruje kopii
bez PHP do `../ecowood-nahled/` a zabalí ji do `ecowood-nahled.zip`. Ta se dá
poslat e-mailem a otevřít dvojklikem. Kontaktní formulář v ní neodesílá.
