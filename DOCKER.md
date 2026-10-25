# Dashboard SDM FIF - Docker Setup

This guide explains how to run the Dashboard SDM FIF application using Docker.

## Prerequisites

- [Docker](https://www.docker.com/get-started) installed (version 20.10 or higher)
- [Docker Compose](https://docs.docker.com/compose/install/) installed (version 2.0 or higher)
- At least 4GB of available RAM
- At least 10GB of free disk space

## Quick Start

### 1. Initial Setup

```bash
# Build frontend assets (required before Docker build)
npm install
npm run build

# Copy the Docker environment file
cp .env.docker .env

# Generate application key
docker-compose run --rm app php artisan key:generate

# Build and start containers
docker-compose up -d --build
```

### 2. Install Dependencies and Run Migrations

```bash
# Install composer dependencies (if needed)
docker-compose exec app composer install

# Run database migrations
docker-compose exec app php artisan migrate

# Seed the database (optional)
docker-compose exec app php artisan db:seed

# Create storage link
docker-compose exec app php artisan storage:link

# Clear and cache configuration
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 3. Access the Application

Open your browser and navigate to:
- **Application**: http://localhost:8080
- **Database**: localhost:3306 (use MySQL client)

## Docker Services

The application runs with the following services:

| Service | Container Name | Port | Description |
|---------|---------------|------|-------------|
| nginx | dashboard-sdm-nginx | 8080 | Web server |
| app | dashboard-sdm-app | 9000 | PHP-FPM application |
| mysql | dashboard-sdm-mysql | 3306 | MySQL database |
| redis | dashboard-sdm-redis | 6379 | Cache & session store |

## Common Commands

### Container Management

```bash
# Start all containers
docker-compose up -d

# Stop all containers
docker-compose down

# Restart all containers
docker-compose restart

# View logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f app
docker-compose logs -f nginx
```

### Application Commands

```bash
# Run artisan commands
docker-compose exec app php artisan [command]

# Run composer commands
docker-compose exec app composer [command]

# Access MySQL database
docker-compose exec mysql mysql -u root -p

# Access container shell
docker-compose exec app bash

# Clear all caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Database Management

```bash
# Run migrations
docker-compose exec app php artisan migrate

# Rollback migrations
docker-compose exec app php artisan migrate:rollback

# Fresh migration (drop all tables and re-migrate)
docker-compose exec app php artisan migrate:fresh

# Fresh migration with seeding
docker-compose exec app php artisan migrate:fresh --seed

# Export database
docker-compose exec mysql mysqldump -u root -p dashboard_sdm > backup.sql

# Import database
docker-compose exec -T mysql mysql -u root -p dashboard_sdm < backup.sql
```

### Queue Worker (if enabled)

```bash
# Start queue worker
docker-compose exec app php artisan queue:work

# Restart queue workers
docker-compose exec app php artisan queue:restart
```

## File Permissions

If you encounter permission issues:

```bash
# Fix storage and cache permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

## Environment Configuration

### Using Local Database

The default `.env.docker` uses the containerized MySQL database. If you prefer to use your existing remote database, update these values in `.env`:

```env
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Changing Ports

To change the application port, edit `.env`:

```env
APP_PORT=8080  # Change to your desired port
```

Then restart containers:

```bash
docker-compose down
docker-compose up -d
```

## Troubleshooting

### Container won't start

```bash
# Check container status
docker-compose ps

# View error logs
docker-compose logs

# Remove and rebuild
docker-compose down -v
docker-compose up -d --build
```

### Database connection issues

```bash
# Check if MySQL is running
docker-compose ps mysql

# Check MySQL logs
docker-compose logs mysql

# Test connection
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### Permission denied errors

```bash
# Reset permissions
docker-compose exec app chown -R www-data:www-data /var/www/html
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Clear everything and start fresh

```bash
# Stop and remove all containers, volumes, and images
docker-compose down -v --rmi all

# Rebuild from scratch
docker-compose up -d --build

# Run migrations
docker-compose exec app php artisan migrate --seed
```

## Production Deployment

For production deployment:

1. Update `.env`:
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Use strong passwords
   - Configure proper mail settings

2. Enable HTTPS by adding SSL certificates to Nginx

3. Consider enabling the queue worker service in `docker-compose.yml`

4. Set up automated backups for the database

5. Configure log rotation for storage/logs

## Production Deployment & Cloudflare Tunnel

### 1. Port Allocation on Server
To avoid conflicting with existing services on the host:
- `80`, `443`, `8080`: Used by Coolify Proxy (Traefik)
- `8081`, `8082`: Used by existing frontends
- **`8083`**: Allocated for Dashboard SDM FIF (`APP_PORT=8083`)
- `3307`: MySQL localhost binding
- `6380`: Redis localhost binding

### 2. Fast Deploy Script
Run the automated deployment script directly on the server:
```bash
./deploy.sh
```
This script will:
1. Initialize `.env` from `.env.docker` if not present.
2. Build and launch containers with `docker-compose.prod.yml`.
3. Wait for MySQL to become healthy.
4. Run migrations (`php artisan migrate --force`).
5. Optimize caches (`config:cache`, `route:cache`, `view:cache`).
6. Automatically connect `cloudflare_tunnel` to `dashboard-sdm-network`.

### 3. Routing via Cloudflare Tunnel (`cloudflare_tunnel`)
Since `cloudflare_tunnel` is already running on the server:

#### Option A: Docker Network (Recommended - No Port Exposure Needed)
Connect the existing Cloudflare Tunnel container to the application network:
```bash
docker network connect dashboard-sdm-network cloudflare_tunnel
```
Then in **Cloudflare Zero Trust Dashboard** (`Networks` > `Tunnels` > Your Tunnel > `Configure` > `Public Hostnames`):
- **Subdomain**: `sdm` (or desired name)
- **Domain**: `yourdomain.com`
- **Service**: `HTTP`
- **URL**: `dashboard-sdm-nginx:80`

#### Option B: Host Port Routing
In **Cloudflare Zero Trust Dashboard**:
- **Service**: `HTTP`
- **URL**: `172.17.0.1:8083` (or `localhost:8083`)

---

## Performance Optimization

### Enable OPcache

OPcache is already enabled in the Docker PHP configuration for better performance.

### Database Optimization

```bash
# Optimize tables
docker-compose exec mysql mysqlcheck -u root -p --optimize --all-databases
```

### Redis for Sessions and Cache

The Docker setup uses Redis by default for sessions and cache, providing better performance than file-based storage.

## Support

For issues specific to the Docker setup, check:
- Container logs: `docker-compose logs`
- Laravel logs: `storage/logs/laravel.log`
- Nginx logs: `docker-compose logs nginx`

## License

Same as the main application.
