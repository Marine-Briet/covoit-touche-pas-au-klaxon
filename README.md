# Covoit Touche pas au klaxon

## Context

Fictional project developed as part of a Full Stack Developer training program.

The company operates multiple sites and generates numerous inter-site trips. To reduce the number of vehicles used for the same trip (often with only the driver on board), this application allows employees to share planned trips within the company intranet, encouraging carpooling.

## Tech Stack

- **Backend:** PHP (custom MVC architecture, no framework)
- **Router:** TBD (Composer package)
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap + Sass (custom color palette)
- **Code quality:** PHPStan
- **Testing:** PHPUnit

## Project Structure
├── app/
│   ├── Controllers/
│   └── Models/
├── core/
├── template/
├── public/
│   └── assets/
├── config/
└── composer.json

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

6. Copy `.env.example` to `.env` and fill in your database credentials.

7. Access the application at:
http://localhost/covoit-touche-pas-au-klaxon/public/

## Database

**MLD (textual):**
UTILISATEUR (id_utilisateur, nom, prenom, telephone, email, mot_de_passe, est_admin)
AGENCE (id_agence, nom_ville)
TRAJET (id_trajet, date_depart, date_arrivee, nb_places_tot, nb_places_dispo, #id_utilisateur, #id_agence_depart, #id_agence_arrivee)

**Setup:**
```bash
mysql -u root -p < database/creation.sql
mysql -u root -p < database/population.sql
```

## Usage

*(TODO)*

## Test accounts

- **Admin:** `admin@email.fr` / `password123`
- **Employee:** `alexandre.martin@email.fr` / `password123` (or any of the 20 seeded employees)