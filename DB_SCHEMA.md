Inventory Management DB Schema

This repository contains Laravel 13 migrations for the Inventory Management System (products, purchases, sales, stock movements, warehouses, RBAC, etc.).

How to run:
1. Ensure .env is configured and DB is reachable.
2. php artisan migrate --force

Files added:
- database/migrations/*.php (migration files)
- scripts/rollback_migrations.sh (helpers to rollback migrations)

Notes:
- Migrations include proper FKs, indexes, and soft deletes where appropriate.
- If users table already exists, a safe merge migration was provided.
