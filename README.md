# laravel-freelancing-platform

A Laravel-based freelancing marketplace platform built to manage projects, proposals, contracts, payments, messaging, and client–freelancer workflows.

This project demonstrates practical experience in building a real-world service marketplace with role-based workflows, business logic, and multilingual support.

---

## Project Status

Core marketplace workflows, including project posting, proposal handling, contracts, payments, and messaging, are implemented. The project is being continuously refined as part of my professional portfolio.

---

## Overview

Elancer is a web-based freelancing platform that allows clients to post projects and freelancers to submit proposals, communicate, manage contracts, and follow project-related workflows.

The platform was developed to simulate real freelancing marketplace logic with structured project flows, role-based interactions, and administrative/business features.

---

## Key Features

- Client and freelancer role-based workflow
- Project posting and management
- Proposal submission and review
- Contract management
- Payment-related workflows
- Messaging system
- Categories and tags
- Project filtering and search logic
- API support
- Authentication and token-based access
- Arabic and English language support
- Dashboard and management features

---

## Tech Stack

- **Backend:** PHP, Laravel
- **Database:** MySQL
- **Frontend:** Blade, JavaScript, Tailwind CSS
- **Authentication:** Laravel auth / token-based authentication
- **Architecture:** Web + API support
- **Other Features:** Localization, filtering, project workflow logic

---

## Main Modules

### Client Side
- Post and manage projects
- Review received proposals
- Manage contracts and project flow
- Interact with freelancers through the platform

### Freelancer Side
- Browse available projects
- Submit proposals
- Track contracts and work-related activity
- Interact with clients

### Marketplace Logic
- Categories and tags
- Project filtering
- Budget and type handling
- Business rules for proposals and contracts

### Communication & Payments
- Messaging system between users
- Payment workflow support
- Project-related interactions and status updates

---

## Highlighted Technical Areas

This project demonstrates practical experience in:

- Marketplace platform development
- Laravel business workflow implementation
- Role-based system design
- Proposal and contract logic
- Payment-related workflow development
- Filtering and categorization systems
- Messaging workflow integration
- Multilingual application development
- Web and API architecture

---

## Installation

```bash
git clone https://github.com/omarmusallam/laravel-freelancing-platform.git
cd laravel-freelancing-platform
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
