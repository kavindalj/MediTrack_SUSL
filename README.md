# 🚀 MediTrack SUSL

This repository provides a **Laravel 8 development environment** using Docker, designed for **local development only**. No Docker image building or production deployment is included here. For production, see [Production Setup](#productionserver-deployment-without-docker).

***

## 📑 Table of Contents

- [🏥 Project Overview](#-project-overview)  
- [🧰 Tech Stack](#tech-stack)  
- [📦 Prerequisites](#prerequisites)  
- [⚙️ Development Setup (Docker)](#development-setup-docker)  
  - [1. Clone Repository](#1-clone-repository)  
  - [2. Configure Environment](#2-configure-environment)  
  - [3. Start Docker Containers](#3-start-docker-containers)  
  - [4. Install Dependencies](#4-install-dependencies)  
  - [5. Generate Application Key](#5-generate-application-key)  
  - [6. Run Database Migrations](#6-run-database-migrations)  
  - [7. Seed Database](#7-seed-database)  
  - [8. Access the Application](#8-access-the-application)  
- [🧾 Running Artisan & Composer Commands](#running-artisan--composer-commands)  
- [🚀 Production/Server Deployment (Without Docker)](#productionserver-deployment-without-docker)  
- [✅ Tips](#tips)  
- [🧼 Troubleshooting](#troubleshooting)  

***

## 🏥 Project Overview  

**MediTrack SUSL** is a digital transformation initiative aimed at modernizing medical center operations within educational institutions, with **Sabaragamuwa University of Sri Lanka** serving as the pilot implementation.  

The system focuses on:  

- **💊 Digital Prescription Management**  
  Replaces paper prescriptions with secure digital records, reducing errors.  

- **📦 Medicine Stock & Expiry Analysis**  
  Continuously monitors stock levels, tracks medicine usage.  

- **👩‍⚕️ Staff Efficiency Support**  
  Minimizes paperwork and manual calculations, allowing medical staff to dedicate more time to patient care.  

By streamlining workflows and digitizing records, MediTrack SUSL enhances **accuracy, efficiency, and accessibility** in university medical services.  

***

## Tech Stack

- **Laravel 8** – PHP web framework  
- **PHP 7.4 + Apache** – Web server  
- **MySQL 5.7** – Database server  
- **phpMyAdmin** – Database management GUI  
- **Composer** – PHP dependency manager  

***

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/) installed on your machine  

***

## Development Setup (Docker)

### 1. Clone Repository

```bash
git clone https://github.com/kavindalj/MediTrack_SUSL.git
cd MediTrack_SUSL
```

### 2. Configure Environment

```bash
cp .env.example .env
```

Update `.env` file for Docker services:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 3. Start Docker Containers

```bash
docker compose up -d
```

This will start:

- Laravel App (PHP + Apache)  
- MySQL 5.7  
- phpMyAdmin  

### 4. Install Dependencies

Enter the Laravel container:

```bash
docker compose exec laravel_app bash
```

Inside the container, install Composer if not already installed:

```bash
apt update && apt install -y curl unzip git zip
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

Then install Laravel dependencies:

```bash
composer install
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Seed Database

```bash
php artisan db:seed
exit
```

### 8. Access the Application

- Laravel App → http://localhost:8000  
- phpMyAdmin → http://localhost:8080  

**Login Credentials**

- **MediTrack App**  
  Email: [pharmacist@meditrack.com](mailto:pharmacist@meditrack.com)  
  Password: password123  
  Role: Pharmacist (Full Access)  

- **phpMyAdmin**  
  Username: laravel  
  Password: secret  

***

## Running Artisan & Composer Commands

Enter the Laravel container:

```bash
docker compose exec laravel_app bash
```

Run commands as needed:

```bash
# Composer
composer install
composer update
composer require <package>

# Artisan
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
php artisan route:list
php artisan make:model <ModelName>
php artisan make:controller <ControllerName>
php artisan make:migration create_table_name
```

***

## Production/Server Deployment (Without Docker)

For production, install PHP, Apache/Nginx, MySQL, and Composer directly on the server.

### Prerequisites

- PHP 7.4+ (with mbstring, openssl, pdo, tokenizer, xml, json)  
- Apache or Nginx  
- MySQL 5.7+ / MariaDB  
- Composer  

### Deployment Steps

```bash
# Clone project
git clone https://github.com/kavindalj/MediTrack_SUSL.git
cd MediTrack_SUSL

# Install dependencies
composer install --optimize-autoloader --no-dev

# Setup environment
cp .env.example .env
nano .env  # configure database + app settings

# Generate key
php artisan key:generate

# Setup database
php artisan migrate --force
php artisan db:seed --force
```

***

## Tips

- To stop containers:

```bash
docker compose stop
```

***

## Troubleshooting

- If migrations fail, wait a few seconds for MySQL to initialize and retry.  
- If ports are blocked, ensure ports 8000 and 8080 are free.