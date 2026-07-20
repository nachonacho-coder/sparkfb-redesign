# Spark Fingerboards — Redesign

Custom WordPress theme para sparkfb.com. Stack WooCommerce. Estética skate, light theme.

## Rutas
- **Código:** `/Volumes/MAKI/CODING/sparkfb-redesign/`
- **Local WP:** `/Volumes/MAKI/Local Sites/sparkfb/app/public/` → `http://sparkfb.local`
- **Tema activo en WP local:** `sparkfb-redesign` (NO `sparkfb` — hay dos carpetas, solo esta es el activo)
- **Staging:** `https://sparkfb.com/spark-rebuild/`
- **Repo:** `nachonacho-coder/sparkfb-redesign`

## Entorno local (Local by WP Engine)
- **DB:** base `local`, prefix `egu_`, user/pass `root`/`root`
- **MySQL socket:** `/Users/nachito/Library/Application Support/Local/run/wnW9psdWP/mysql/mysqld.sock`
- **MySQL binary:** `/Applications/Local.app/Contents/Resources/extraResources/lightning-services/mysql-8.4.0/bin/darwin-arm64/bin/mysql`

## Design system
- **Tipografía:** Inter (body) + Space Grotesk (display/headings)
- **Acento:** `#ffff05` (amarillo eléctrico)
- **Botones:** fondo negro + texto blanco
- **Tema:** light (fondo blanco, texto negro)

## Archivos clave
```
style.css              # sistema de diseño completo
functions.php          # setup, WC hooks, location switcher, PEN price
front-page.php         # homepage
page.php               # páginas genéricas (cart, checkout, my-account)
header.php             # sticky header, nav, location switcher, mini-cart
footer.php             # footer 4 cols, logo SVG inline
assets/spark.svg       # logo SVG
assets/js/main.js      # nav drawer, mini-cart, search, gallery
woocommerce/           # WC template overrides
```

## Template hierarchy importante
- `front-page.php` → homepage cuando WP tiene static front page
- `woocommerce.php` → NO CREAR — si existe, intercepta todas las páginas WC

## Location/currency switcher
- Cookie: `sparkfb_location` = `'peru'` | `'internacional'` (default: `'internacional'`)
- Perú (S/): campo `_price_pen` por producto, fallback USD
- `sparkfb_t($es, $en)` → helper bilingüe

## Slugs de categorías WC
- `decks`, `obstaculos`, `trucks`, `wheels`, `tunning`
- Usar `get_term_link()` siempre — NO URLs hardcodeadas
- Shop page ID 10, slug `tienda`

## Deploy — reglas exactas

### MAKI → Local WP
```bash
rsync -av --delete /Volumes/MAKI/CODING/sparkfb-redesign/ "/Volumes/MAKI/Local Sites/sparkfb/app/public/wp-content/themes/sparkfb-redesign/" --exclude=.git
```

### MAKI → Staging (usar MASTER USER, no deploy user)
```bash
lftp -u "nacho@sparkfb.com","nacho123" ftp://ftp.sparkfb.com -e "set ssl:verify-certificate no; mirror --reverse --delete --transfer-all --exclude '\.git' /Volumes/MAKI/CODING/sparkfb-redesign/ /sparkfb.com/public_html/spark-rebuild/wp-content/themes/sparkfb-redesign/; quit"
```
- Ruta correcta: `/sparkfb.com/public_html/spark-rebuild/...` (NO `/public_html/spark-rebuild/` — esa carpeta es vacía)
- Después de deploy: purgar caché en SiteGround → Velocidad → Almacenamiento en caché

### Antes de cada deploy
Incrementar `Version:` en `style.css`.

## Producción
- DB: `dbwutibpxdp3jk`, prefix `egu_`
- DB staging (NO usar): `db9wxnixld4yb5`, prefix `ddh_`
- FTP master: `nacho@sparkfb.com` / `nacho123`
