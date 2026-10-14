#!/usr/bin/env bash
# Vygeneruje statický náhled webu, který jde poslat e-mailem a otevřít bez PHP.
#
#   cd ecowood && ./build-nahled.sh
#
# Výsledek: ../ecowood-nahled/ a ../ecowood-nahled.zip

set -euo pipefail

PORT=8099
SRC="$(cd "$(dirname "$0")" && pwd)"
OUT="$(dirname "$SRC")/ecowood-nahled"
PAGES=(index.php kompost.php substraty.php sluzby.php faq.php kontakt.php)

php -S "localhost:$PORT" -t "$SRC" >/dev/null 2>&1 &
SERVER_PID=$!
trap 'kill $SERVER_PID 2>/dev/null || true' EXIT

for _ in $(seq 20); do
	curl -sf -o /dev/null "http://localhost:$PORT/index.php" && break
	sleep 0.2
done

rm -rf "$OUT"
mkdir -p "$OUT"
cp -R "$SRC/css" "$SRC/js" "$SRC/images" "$OUT/"
mkdir -p "$OUT/data"
cp "$SRC"/data/*.pdf "$OUT/data/"

for page in "${PAGES[@]}"; do
	# Odkazy na .php přepsat na .html, ať náhled funguje i z disku
	curl -s "http://localhost:$PORT/$page" \
		| sed -E 's/(href="[a-z-]+)\.php/\1.html/g; s/action="mail_sender\.php"/action="#"/' \
		> "$OUT/${page%.php}.html"
done

cd "$(dirname "$OUT")"
rm -f ecowood-nahled.zip
zip -qr ecowood-nahled.zip "$(basename "$OUT")"

echo "Hotovo:"
echo "  složka: $OUT"
echo "  archiv: $(dirname "$OUT")/ecowood-nahled.zip"
