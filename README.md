---

# 🚀 Laravel Docker Development Setup

This repository provides a development environment for a Laravel 8 application using Docker. It's designed for **local development only** — no Docker image building or production deployment is involved.

---

## 🧰 Tech Stack

- **Laravel 8** – PHP web framework
- **PHP 7.4 + Apache** – Web server
- **MySQL 5.7** – Database server
- **phpMyAdmin** – Database management GUI
- **Composer** – PHP dependency manager (installed inside the container)

---

## 📦 Prerequisites

Make sure you have the following tools installed on your machine:

- [Docker](https://docs.docker.com/get-docker/)

---

## ⚙️ Setup Instructions

### 1. 📥 Clone the repository

Clone the project to your local development environment:

```bash
git clone https://github.com/yourusername/your-repo.git
cd your-repo
````

---

### 2. 📝 Copy and Configure Environment File

Copy the example environment configuration file:

```bash
cp .env.example .env
```

Ensure the database settings match the `docker-compose.yml`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

These values correspond to the service defined in the Docker setup (`db` is the MySQL container name).

---

### 3. 🐳 Start Docker Containers

Use `docker-compose` to start the application stack:

```bash
docker compose up -d
```

This will start the following services:

* Laravel application (PHP + Apache)
* MySQL 5.7 database
* phpMyAdmin

Wait a few seconds for the MySQL server to initialize before proceeding to the next step.

---

### 4. 🧰 Install Composer Dependencies

Enter the Laravel container:

```bash
docker exec -it laravel_app bash
```

Inside the container, install required utilities and Composer:

```bash
apt update && apt install -y curl unzip git zip
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer install
```

---

### 5. 🔐 Generate Application Key

Still inside the container, run the following to generate the Laravel app key:

```bash
php artisan key:generate
```

---

### 6. 🗃️ Run Database Migrations

Run the database migrations to create required tables:

```bash
php artisan migrate
```

Then exit the container:

```bash
exit
```

---

## 🌐 Access the Application

After setup, you can access the services through your browser:

* **Laravel App**: [http://localhost:8000](http://localhost:8000)
* **phpMyAdmin**: [http://localhost:8080](http://localhost:8080)

> Login credentials for phpMyAdmin:
>
> * **Username**: `laravel`
> * **Password**: `secret`

---

## 🧾 Running Artisan and Composer Commands

To run Laravel Artisan or Composer commands, first enter the Laravel container:

```bash
docker exec -it laravel_app bash
```

Then you can use commands such as:

```bash
# Composer Commands
composer install
composer update
composer require <package-name>

# Artisan Commands
php artisan migrate
php artisan db:seed
php artisan route:list
php artisan make:model <ModelName>
php artisan make:controller <ControllerName>
php artisan make:migration create_table_name
```

---

## ✅ Tips

* To stop all services:

  ```bash
  docker compose down
  ```

---

## 🧼 Troubleshooting

* If migrations fail due to MySQL not being ready, wait a few more seconds and try again.
* Make sure ports `8000` (for Laravel) and `8080` (for phpMyAdmin) are not being used by other apps.

---

