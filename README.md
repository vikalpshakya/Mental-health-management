# Mental Health Portal

A comprehensive mental health improvement website where users can take mental health tests, track their progress, and consult with mental health experts.

## Features

- User authentication and authorization
- Mental health assessment tests
- Test result tracking and recommendations
- Expert consultation booking system
- Admin dashboard for managing tests and experts
- Responsive and modern UI

## Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js and NPM

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd mental-health-portal
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create a copy of the `.env.example` file and configure your environment:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mental_health_portal
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Create an admin user:
```bash
php artisan tinker
User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'admin']);
```

9. Start the development server:
```bash
php artisan serve
```

10. In a separate terminal, start the Vite development server:
```bash
npm run dev
```

## Usage

1. Access the website at `http://localhost:8000`
2. Register a new user account
3. Take mental health tests
4. Book appointments with experts
5. View your test results and recommendations

## Admin Access

1. Log in with the admin credentials:
   - Email: admin@example.com
   - Password: password

2. Access the admin dashboard at `/admin/dashboard`
3. Manage tests, users, and experts
4. View appointment statistics

## Expert Access

1. Create expert accounts through the admin dashboard
2. Experts can view and manage their appointments
3. Provide feedback and recommendations to users

## Contributing

1. Fork the repository
2. Create a new branch
3. Make your changes
4. Submit a pull request

## License

This project is licensed under the MIT License.
# Mental-health-management
