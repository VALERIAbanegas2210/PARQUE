#!/bin/bash

# Agrega tu token de autenticación de Ngrok
#./ngrok authtoken 2p57aEPtD5vebramoweotl2yviJ_6v6XLmENRU62shcvdJdyj

# Inicia Ngrok en segundo plano
echo "Iniciando Ngrok..."
./ngrok http 8000 > /dev/null &

# Espera un momento para que Ngrok inicie
sleep 5

# Obtén la URL pública generada por Ngrok
echo "Obteniendo la URL de Ngrok..."
#curl -s http://localhost:4040/api/tunnels

NGROK_URL=$(curl -s http://localhost:4040/api/tunnels | jq -r '.tunnels[0].public_url')
echo "URL de Ngrok obtenida: $NGROK_URL"
# Verifica si se pudo obtener una URL de Ngrok
if [ -n "$NGROK_URL" ]; then
  # Actualiza el archivo .env con la nueva URL de Ngrok
  sed -i "s|^APP_URL=.*|APP_URL=${NGROK_URL}|g" .env
  echo "APP_URL actualizada a $NGROK_URL"
else
  echo "No se pudo obtener la URL de Ngrok"
fi

# Inicia el servidor de Laravel
echo "Iniciando servidor Laravel..."

nohup php artisan serve > /dev/null 2>&1 &
