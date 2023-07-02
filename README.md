# Test Coding CI

Test Coding Basic with CI4

## Table of Contents

- [Getting Started](#getting-started)
  - [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Getting Started

These instructions will help you get a copy of the project up and running on your local machine.

### Installation

1. Clone the repository:

```bash
git clone https://github.com/hiikalll/test-coding-ci4.git
```

Navigate to the project directory:

```bash
cd project-name
```

Install the project dependencies using Composer:

```bash
composer install
```

Copy the .env.example file to .env:

```bash
cp .env.example .env
```

Make the database

<!-- generate database -->

```bash
php spark db:create test-coding-ci4
```

Update the .env file with your database credentials and other configuration settings. Make sure to set the database.default.database value to test-coding-ci4 (assuming you want to use the database named test-coding-ci4).

Generate an application key:

```bash
php spark key:generate
```

Run the database migrations:

```bash
php spark migrate
```

Seed the database with default data:

```bash
php spark db:seed UserSeeder
```

This will create an admin user with the email ``admin@admin.com`` and password ``adminpassword``.

Start the development server:

```bash
php spark serve
```

You can now access the project at [http://localhost:8080](http://localhost:8080)
