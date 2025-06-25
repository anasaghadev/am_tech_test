# Project Setup Guide

## Installation & Setup

# Clone repository

git clone https://github.com/anasaghadev/am_tech_test.git
cd your-project

# Install PHP dependencies

composer install

# Install JavaScript dependencies

npm install

# Configure environment

cp .env.example .env
php artisan key:generate

# rename the file .env.example to .env

# Build frontend assets

npm run build

# Run database migrations and seeding

php artisan migrate --seed


#Running the Application

php artisan serve

# Now Open In Your Browser

http://localhost:8000

# login

username: admin@example.com
password: password

# start managing your tasks

