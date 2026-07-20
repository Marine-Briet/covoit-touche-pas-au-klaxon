# Covoit Touche pas au klaxon

## Context

Fictional project developed as part of a Full Stack Developer training program.

The company operates multiple sites and generates numerous inter-site trips. To reduce the number of vehicles used for the same trip (often with only the driver on board), this application allows employees to share planned trips within the company intranet, encouraging carpooling.

## Tech Stack

- **Backend:** PHP (custom MVC architecture, no framework)
- **Router:** [izniburak/router](https://packagist.org/packages/izniburak/router)
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap + Sass (custom color palette)
- **Code quality:** PHPStan (level 5)
- **Testing:** PHPUnit

## Project Structure
├── app/
│ ├── Controllers/
│ └── Models/
├── core/
├── template/
├── public/
│ └── assets/
├── config/
├── database/
├── tests/
└── composer.json

## Installation

### Prerequisites

- XAMPP (or WAMP/Laragon) with PHP 8.2+ and MySQL/MariaDB
- Composer
- Node.js & npm (for Sass compilation)

### Steps

1. Clone the repository into your server's document root (e.g. `htdocs/` for XAMPP):
```bash
   git clone https://github.com/Marine-Briet/covoit-touche-pas-au-klaxon.git
```

2. Install PHP dependencies:
```bash
   composer install
```

3. Install front-end dependencies:
```bash
   npm install
```

4. Compile the Sass stylesheet:
```bash
   npm run build:css
```
   (Use `npm run watch:css` during development to recompile automatically on changes.)

5. Set up the database (see [Database](#database) section below).

6. Configure your database credentials in `config/config.php` (see template below).

7. Access the application at:
http://localhost/covoit-touche-pas-au-klaxon/public/

## Database

### MLD (textual)

UTILISATEUR (id_utilisateur, nom, prenom, telephone, email, mot_de_passe, est_admin)
AGENCE (id_agence, nom_ville)
TRAJET (id_trajet, date_depart, date_arrivee, nb_places_tot, nb_places_dispo, #id_utilisateur, #id_agence_depart, #id_agence_arrivee)

### Setup (development database)

```bash
mysql -u root -p < database/01_creation.sql
mysql -u root -p < database/02_population.sql
```

### Configuration

Create `config/config.php` with your credentials:

```php
<?php
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'touche_pas_au_klaxon');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'your_user');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', 'your_password');
}
if (!defined('DB_CHARSET')) {
    define('DB_CHARSET', 'utf8mb4');
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/covoit-touche-pas-au-klaxon/public');
}
```

> The `if (!defined(...))` guards allow this file to coexist safely with `config/config.test.php` (used for automated tests) without triggering a "constant already defined" error.

## Usage

- **Home page** (public): lists all upcoming trips with available seats, sorted by departure date.
- **Login**: employees log in with their email and password (accounts are seeded from HR data, see [Test accounts](#test-accounts)).
- **Logged-in users** can:
  - View trip details (contact person, phone, email, total seats) in a modal.
  - Propose a new trip.
  - Edit or delete trips they authored.
- **Administrators** have access to a dashboard to:
  - List all users (read-only, per HR constraints).
  - Create, edit, and delete agencies (cities).
  - List all trips and delete any of them.

## Tests & Code Quality

### PHPStan (static analysis)

```bash
vendor/bin/phpstan analyse
```
Configured at level 5 (see `phpstan.neon`).

### PHPUnit (unit tests)

A dedicated test database is required (see below), then run:

```bash
vendor/bin/phpunit
```

**Test database setup:**

```bash
mysql -u root -p < database/01_creation_test.sql
```
(adapt the database name to `touche_pas_au_klaxon_test` if needed, and grant the necessary privileges to your DB user on this database)

Create `config/config.test.php` with the same structure as `config/config.php`, but pointing to `touche_pas_au_klaxon_test`.

**Coverage:** write operations (create/edit/delete) are tested for `AgenceModel` and `TrajetModel`.

> Note: `UtilisateurModel` has no write tests, as the application does not expose any create/edit/delete functionality for users — employee data is read-only, sourced from the company's HR system (per project brief).

## Test accounts

- **Admin:** `admin@email.fr` / `password123`
- **Employee:** `alexandre.martin@email.fr` / `password123` (or any of the 20 seeded employees)