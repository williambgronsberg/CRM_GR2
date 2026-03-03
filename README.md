# CRM_GR2

Et enkelt CRM-prosjekt (kunde- og personadministrasjon) bygget i PHP.

## Om prosjektet

Dette repositoryet inneholder struktur for en webapplikasjon med sider for å:

- legge til, oppdatere og slette kunder
- legge til, oppdatere og slette personer
- vise lister over kunder og personer
- håndtere innlogging og kontoinformasjon

Filstrukturen viser planlagt moduldeling i `pages/`, delte komponenter i `pages/pieces/`, og stilark i `assets/`.

## Prosjektstruktur

```text
.
├── index.php
├── assets/
│   └── style.css
├── pages/
│   ├── about_us.php
│   ├── login.php
│   ├── add_customer.php
│   ├── update_customer.php
│   ├── delete_customer.php
│   ├── list_customers.php
│   ├── add_person.php
│   ├── update_person.php
│   ├── delete_person.php
│   ├── list_people.php
│   ├── update_account.php
│   └── pieces/
│       ├── head.php
│       ├── nav.php
│       └── footer.php
└── Details/
    ├── Kravspesifikasjon.docx
    └── TekniskeDetaljer.docx
```

## Kom i gang

### Krav

- PHP 8.0 eller nyere
- En lokal webserver (f.eks. Apache via XAMPP/WAMP/MAMP) eller PHP sin innebygde server

### Kjør lokalt

Fra prosjektroten kan du starte en enkel utviklingsserver:

```bash
php -S localhost:8000
```

Åpne deretter:

```text
http://localhost:8000
```

## Status

Per nå består prosjektet hovedsakelig av filstruktur og dokumentasjon. Implementasjon av funksjonalitet må fylles inn i de relevante PHP-filene.

## Videre arbeid (forslag)

- Legg til databasekobling (f.eks. MySQL + PDO)
- Implementer CRUD-funksjoner i hver side
- Legg til validering og feilhåndtering i skjemaer
- Sikre innlogging med passordhashing og sesjonshåndtering
- Skriv enkle tester for kritisk logikk

## Lisens

Ingen lisens er spesifisert ennå.
