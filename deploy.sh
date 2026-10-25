#!/bin/bash
set -e

# ==============================================================================
# Dashboard SDM FIF - Automated Production Deployment Script
# ==============================================================================

echo "=========================================================="
echo " Starting Dashboard SDM FIF Production Deployment..."
echo "=========================================================="

# 1. Environment file check
if [ ! -f .env ]; then
    echo "[+] Creating .env from .env.docker..."
    cp .env.docker .env
    echo "[!] Please verify credentials in .env if needed."
fi

# Ensure DB_PASSWORD is not empty (MySQL requires a non-empty password)
if grep -q "^DB_PASSWORD=$" .env 2>/dev/null || grep -q '^DB_PASSWORD=""$' .env 2>/dev/null || grep -q "^DB_PASSWORD=''$" .env 2>/dev/null; then
    RANDOM_PASS=$(head -c 16 /dev/urandom | base64 | tr -dc 'a-zA-Z0-9' | head -c 16)
    sed -i.bak "s/^DB_PASSWORD=.*/DB_PASSWORD=${RANDOM_PASS}/" .env && rm -f .env.bak
    echo "[+] Auto-generated secure DB_PASSWORD in .env"
fi

# 2. Build and start containers
echo "[+] Building and starting Docker containers..."
docker compose -f docker-compose.prod.yml up -d --build

# 3. Wait for MySQL to finish initialization & become ready
echo "[+] Waiting for MySQL to become ready (first-time init can take up to 60s)..."
RETRIES=60
until docker compose -f docker-compose.prod.yml exec -T mysql mysqladmin ping -h localhost --silent 2>/dev/null || [ $RETRIES -eq 0 ]; do
    echo "    Waiting for MySQL... ($RETRIES attempts left)"
    RETRIES=$((RETRIES-1))
    sleep 2
done

if [ $RETRIES -eq 0 ]; then
    echo "[-] MySQL did not become ready in time. Container logs:"
    docker compose -f docker-compose.prod.yml logs mysql
    echo ""
    echo "[!] Tip: If MySQL was interrupted during first-time initialization, run:"
    echo "    docker compose -f docker-compose.prod.yml down -v"
    echo "    ./deploy.sh"
    exit 1
fi

echo "[+] MySQL is ready and responding!"

# 4. Generate app key if not set
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "[+] Generating Laravel APP_KEY..."
    docker compose -f docker-compose.prod.yml exec -T app php artisan key:generate --force
fi

# 5. Database migrations
echo "[+] Running database migrations..."
docker compose -f docker-compose.prod.yml exec -T app php artisan migrate --force

# 6. Optimize Laravel performance (caching)
echo "[+] Optimizing Laravel caches..."
docker compose -f docker-compose.prod.yml exec -T app php artisan config:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan route:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan view:cache
docker compose -f docker-compose.prod.yml exec -T app php artisan storage:link || true

# 7. Cloudflare Tunnel Network Hookup
echo "[+] Checking for running cloudflare_tunnel container..."
if docker ps --format '{{.Names}}' | grep -q "^cloudflare_tunnel$"; then
    echo "[+] Connecting 'cloudflare_tunnel' to 'dashboard-sdm-network'..."
    docker network connect dashboard-sdm-network cloudflare_tunnel 2>/dev/null || echo "    (cloudflare_tunnel is already connected to dashboard-sdm-network)"
    echo "----------------------------------------------------------"
    echo " Cloudflare Tunnel Direct Routing is READY!"
    echo " In your Cloudflare Zero Trust Dashboard:"
    echo "   - Service Type : HTTP"
    echo "   - URL          : dashboard-sdm-nginx:80"
    echo "   (or via host port : http://172.17.0.1:8083)"
    echo "----------------------------------------------------------"
else
    echo "[-] cloudflare_tunnel container not found or named differently."
fi

echo "=========================================================="
echo " Deployment completed successfully!"
echo " Local test URL : http://localhost:8083"
echo "=========================================================="
