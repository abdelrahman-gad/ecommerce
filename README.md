#  Theqahalenjaz Assessment Task

This project is designed to theqahalenjaz assessment task.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL

### Installing

Follow these steps to get the project running:

1. Clone the repository:

    ```bash
    git clone https://github.com/abdelrahman-gad/ecommerce.git
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Create a copy of the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Update the `.env` file with your database credentials.

6. Update .env Variables

```
TWILIO_SID=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_FROM=xxxxxxxxxxx
JWT_SECRET=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

7. Run database migrations:

    ```bash
    php artisan migrate
    ```

### Running Tests

To run tests

```bash
php artisan test 
```

### Seeding database

To run tests:

```bash
php artisan db:seed
```


### Default Credentials for admin side

For testing purposes, the project provides the following default credentials:

- **Username:** `admin@admin.com`
- **Password:** `password`



### Default Credentials for user side

For testing purposes, the project provides the following default credentials:

- **Username:** `user@user.com`
- **Password:** `password`















