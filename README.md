# Elancer

Marketplace demo built with Laravel 8 for showcasing client, freelancer, and admin flows in a portfolio-friendly setup.

## What is ready

- Public home page with seeded categories and featured projects
- Client project management flow
- Freelancer profile and proposals flow
- Admin dashboard access for categories and roles
- Authentication routes working with registration, login, password reset, email verification, and password confirmation
- Portfolio seed data for clean browsing after a fresh migration

## Quick start

1. Copy `.env` and confirm your local database credentials.
2. Run `php artisan key:generate` if the app key is missing.
3. Run `php artisan migrate:fresh --seed`.
4. Run `php artisan serve`.
5. Open `http://127.0.0.1:8000`.

## Demo accounts

All seeded accounts use the password `password123`.

- Admin: `omar@gmail.com`
- Client: `client1@elancer.test`
- Client: `client2@elancer.test`
- Freelancer: `freelancer1@elancer.test`
- Freelancer: `freelancer2@elancer.test`
- Freelancer: `freelancer3@elancer.test`

## Entry points

- Public site: `/`
- User login: `/login`
- User registration: `/register`
- Admin login: `/admin/login`
- Admin dashboard: `/admin/dashboard`

## Seeders

The main seeder now loads:

- `RolesTableSeeder`
- `CategoriesTableSeeder`
- `AdminsTableSeeder`
- `PortfolioDemoSeeder`

These seeders create realistic categories, roles, clients, freelancers, projects, proposals, and one active contract for presentation purposes.

## Verification

- Tests: `php artisan test`
- Current status: `32 passed`

## Notes

- If Composer cache regeneration fails on Windows because of a lock in `bootstrap/cache/packages.php`, the application can still run normally if migrations, tests, and seeders succeed.
