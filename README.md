# WEBT_25-26_04-CORE

WEBT-VT | CORE | 04 - Composer and Views in MVC

## Composer Infos

* ```composer require {package}``` to install
* https://packagist.org to search for composer packages
* ```composer dump-autoload``` to reload Autoloading

## Digital Meal Plan – Project Overview

This project is a sample web application for a **Digital Meal Plan** and was developed as part of the exercise **WEBT
Core – Composer & MVC Templating**.

The goal of the project is to demonstrate:

* how to use Composer in a PHP project
* how to implement a simple custom templating engine
* how to render dynamic content using loops
* how to generate and integrate QR codes using `endroid/qr-code`

---

## Project Structure (High-Level)

```
├── composer.json              # Composer configuration & dependencies
├── composer.lock              # Locked dependency versions
├── public/
│   ├── index.php               # Main page: displays all meal plans
│   ├── api.php                 # JSON API for single meal
│   ├── form.php                # Interactive QR code generator form
│   ├── qrCodeExample.php       # Simple QR code demo script
│   └── styles/
│       └── style.css           # Global styling for the project
├── src/                        # PHP source code (business logic)
│   ├── Api/
│   │   └── GetMeals.php        # Returns a meal as JSON
│   ├── QrCode/
│   │   └── QrCodeBuilder.php   # Wrapper for endroid/qr-code
│   ├── Seeder/
│   │   └── MealSeeder.php      # Generates example meal plans
│   └── View/
│       └── TemplateEngine.php  # Custom templating engine
├── templates/
│   ├── index.html              # Template for meal plan overview
│   └── form.html               # Template for QR code form
└── vendor/                     # Composer dependencies (auto-generated)
```

---

### User Stories 1–3: Composer & QR Code Package

**Relevant files:**

* `composer.json`
* `vendor/`
* `public/qrCodeExample.php`

Composer is initialized, PSR-4 autoloading is configured, and the package `endroid/qr-code` is
installed and used.

---

### User Story 4: Meal Plan HTML Prototype

**Relevant files:**

* `templates/index.html`
* `public/styles/style.css`

Defines the responsive HTML structure and basic styling for displaying multiple meal plans.

---

### User Stories 5 & 6: Templating Engine & Dynamic Rendering

**Relevant files:**

* `src/View/TemplateEngine.php`
* `public/index.php`
* `templates/index.html`

The custom `TemplateEngine` replaces placeholders and supports loop constructs to dynamically render any number of meal
plans and meals.

---

### User Story 7: QR Code Generation & Integration

**Relevant files:**

* `src/QrCode/QrCodeBuilder.php`
* `public/index.php`
* `public/api.php`

QR codes are generated for each meal plan and link to a JSON API endpoint that returns the meal data.

---

### User Story 8: Interactive QR Code Generator

**Relevant files:**

* `public/form.php`
* `templates/form.html`

Users can enter a meal ID and generate a QR code dynamically via a styled form.

---

## File Descriptions

### `public/index.php`

* Main entry point of the application
* Loads demo data using `MealSeeder`
* Generates QR codes for each meal plan
* Passes structured data to the template engine

### `public/api.php`

* Simple JSON API endpoint
* Returns a single meal plan by ID
* Used as the target URL for QR codes

### `public/form.php`

* Handles GET and POST requests
* Validates user input (meal ID)
* Generates QR codes dynamically
* Renders output via `form.html`

### `src/View/TemplateEngine.php`

* Custom mini templating engine
* Replaces placeholders in HTML templates
* Supports loops and nested loops
* Ensures separation of logic and presentation

### `src/QrCode/QrCodeBuilder.php`

* Encapsulates QR code generation logic
* Wraps the `endroid/qr-code` library
* Provides a clean and reusable interface

### `src/Seeder/MealSeeder.php`

* Generates demo meal plan data
* Simulates database content
* Used for dynamic rendering

---

## Setup & Run the Project

```bash

docker compose up -d
docker exec -it CORE4 bash

git config --global --add safe.directory /var/www/html
composer install
```

Open in your browser:

* http://localhost:8080
* http://localhost:8080/form.php

---