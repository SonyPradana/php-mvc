#!/bin/bash

# Install PHP Dependencies
composer install

# Configure Environment
cp .env.example .env

# Install JavaScript Dependencies
npm install

# Build Frontend Assets
npm run dev

# Run the CLI
php cli --help
