#!/bin/bash
# ================================
# POS - Chrome Kiosk Printing
# ================================

# Fecha Chrome / Chromium se estiver aberto
pkill -f chrome >/dev/null 2>&1
pkill -f chromium >/dev/null 2>&1

# Aguarda 2 segundos
sleep 2

# URL da aplicação POS
URL="http://localhost:8000"

# Detecta Chrome ou Chromium
if command -v google-chrome >/dev/null 2>&1; then
    BROWSER="google-chrome"
elif command -v chromium-browser >/dev/null 2>&1; then
    BROWSER="chromium-browser"
elif command -v chromium >/dev/null 2>&1; then
    BROWSER="chromium"
else
    echo "Chrome ou Chromium não encontrado."
    exit 1
fi

# Executa em modo kiosk com impressão silenciosa
$BROWSER \
  --kiosk \
  --kiosk-printing \
  --disable-infobars \
  --disable-session-crashed-bubble \
  --noerrdialogs \
  "$URL"
