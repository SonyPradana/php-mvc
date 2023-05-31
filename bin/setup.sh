#!/bin/bash

# Install PHP Dependencies
composer install

# Configure Environment
cp .env.example .env

# Install JavaScript Dependencies
npm install

# Build Frontend Assets
npm run build

# lint and run test
composer lint
composer test

# Run the CLI
php cli
