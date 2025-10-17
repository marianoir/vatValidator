## Italian Vat Validator

Application to validate whether a number is an italian valid vat por not. 

## Requirements

- XAMPP (PHP 8, MySQL)
- Web browser

## Installation


1) Download and install XAMPP
2) Go to xampp/htdocs 
3) git clone  https://github.com/marianoir/vatValidator
3) Start both apache and mysql server
4) Open file /database/seed.sql copy and paste into phpmyadmin http://localhost/phpmyadmin/index.php
or create database with  mysql -u root -p < database/seed.sql
 
## Access

http://localhost/vatValidator.php (validate csv)

http://localhost/validateOne.php (online form)

## CSV Format (see exampleVat.csv)

id,vat
001,IT12345678901
002,98765432158

## Features

- Validate italian vats when uploading a csv with data (read the exampleVat.csv to see the structure), the screen shows the first table with valid and corrected vats and a second table below with invalid vats.
- First row is ignored.
- Validate single italian vat using a online form (http://localhost/validateOne.php) 
- Corrects italian vat that doesnt have the "IT" as prefix.
- Throws error in case the VAT is invalid or incomplete.
- Saves data in database

## Database

Table: `vat_numbers`
- `id` - auto increment
- `client_id` - from CSV
- `vat_number` - validated VAT
- `created_at` - timestamp