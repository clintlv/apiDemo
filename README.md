# Laravel Inventory Batch Adjustment Demo
This project is a simple Laravel API for warehouse batch inventory adjustment with predefined adjustment reasons.

## Design Decisions
1. Separate `adjustment_reasons` table, allow add/edit reasons without changing source code.
2. Use database transaction for inventory update to guarantee atomicity. If anything fails, rollback all changes.
3. FormRequest for input validation.
4. API Resource to standardize JSON response and eager load relations to avoid N+1 problem.
5. Keep business logic simple, no over-engineering.

## Setup
1. git clone repository
2. cd project folder
3. composer install
4. configure database in .env
5. php artisan key:generate
6. php artisan migrate --seed
7. php artisan serve

## API Endpoints
GET /api/adjustment-reasons -> list active adjustment reasons
POST /api/inventory-adjustments -> create inventory adjustment
Request body example:
{
"batch_id":1,
"adjustment_reason_id":1,
"new_quantity":92,
"note":"After physical count, quantity changed to 92"
}
GET /api/inventory-adjustments/{id} -> view adjustment with related data
