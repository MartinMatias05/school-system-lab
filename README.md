# School Management System — Laravel Lab Exam

A Laravel application based on the supplied lab-exam handout. It covers student records, courses and enrollment, course activities, student submissions, optional file uploads, and grading/feedback.

## Features

- Register students, browse a paginated roster, view student details, and delete a student record.
- Create and browse courses.
- Enroll a student in a course while preventing duplicate enrollments.
- Create course activities with instructions, maximum points, and a due date.
- Accept one submission per enrolled student per activity (text/link and/or an optional allowed file type).
- View submitted work and save a score and feedback.
- Validate input on the server and protect form requests with Laravel CSRF tokens.
- Seed three sample courses to make the first test run easier.

## Technology

- PHP 8.3 or newer (the supplied environment uses PHP 8.4)
- Laravel 13
- Composer
- MySQL/MariaDB through XAMPP
- Blade templates and Tailwind CSS CDN for the UI (no Node/npm build step required)

## 1. Place the project in a new folder

Extract this ZIP into a new location such as:

```text
C:\xampp\htdocs\school-system-lab
```

Do not extract it on top of your previous `school-system` or `school-system-new` folders.

Open that new `school-system-lab` folder in Visual Studio Code.

## 2. Install PHP dependencies

Open the VS Code terminal using **Terminal → New Terminal** and run:

```powershell
composer install
```

If the terminal says `composer` is not recognized and PHP is installed at `C:\xampp\php84`, run the following in that same PowerShell terminal first:

```powershell
$env:Path = "C:\xampp\php84;$env:Path"
composer --version
composer install
```

Composer downloads Laravel and the required packages into the `vendor` folder. The ZIP intentionally does not include `vendor` because these dependencies should be installed on your own computer.

## 3. Configure the environment

After Composer finishes, make a local `.env` file if one was not created automatically:

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```powershell
php artisan key:generate
```

Open `.env` and confirm the local database settings:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_system_lab
DB_USERNAME=root
DB_PASSWORD=
```

These are common XAMPP defaults. If your MySQL root account uses a password or a different port, adjust those values accordingly.

## 4. Create the database in XAMPP

1. Open the XAMPP Control Panel.
2. Start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin` in your browser.
4. Create a database named `school_system_lab` using the `utf8mb4_unicode_ci` collation.
5. Return to the VS Code terminal.

Then run:

```powershell
php artisan migrate --seed
```

This creates the five application tables and seeds sample courses. It does not create demo student records.

Create the public storage link for optional uploaded submissions:

```powershell
php artisan storage:link
```

## 5. Run the application

```powershell
php artisan serve
```

Open the URL shown by Artisan, normally `http://127.0.0.1:8000`.

## Recommended demo workflow

1. Open **Courses** and confirm that `IT101`, `CS102`, and `WEB201` appear. Create another course if needed.
2. Register a student.
3. Open the student record and enroll them in a course.
4. Create an activity under that course.
5. Open the activity and submit an answer or file for the enrolled student.
6. Review the submission and save a score and optional feedback.

## Useful commands

```powershell
php artisan route:list
php artisan migrate:status
php artisan db:seed
php artisan test
```

`php artisan migrate:fresh --seed` deletes and recreates all tables and data. **Do not run it if you need to keep existing records.**

## Project structure

```text
school-system-lab/
├── app/
│   ├── Http/Controllers/
│   │   ├── ActivityController.php
│   │   ├── Controller.php
│   │   ├── CourseController.php
│   │   └── StudentController.php
│   ├── Models/
│   │   ├── Activity.php
│   │   ├── Course.php
│   │   ├── Student.php
│   │   ├── Submission.php
│   │   └── User.php
│   └── Providers/AppServiceProvider.php
├── bootstrap/
├── config/
├── database/
│   ├── migrations/   # five application tables
│   └── seeders/      # three sample courses
├── resources/views/
│   ├── activities/
│   ├── courses/
│   ├── layouts/
│   └── students/
├── routes/web.php
└── tests/Feature/
```

## Design notes and intentional corrections

The handout's controller import examples use malformed namespace separators in a few places. This project uses the valid PHP namespace `App\Http\Controllers`.

The handout defines course models and course enrollment but does not provide a course creation controller or interface. A small `CourseController` and two course views are included so the system can be used without manually inserting courses in phpMyAdmin.

The handout uses resource routes even though the provided controllers omit some resource methods. This implementation registers only routes that are implemented. It also prevents duplicate enrollments and duplicate submissions, checks that a submitting student is enrolled in the activity's course, and supports the `score`, `feedback`, and `file_path` fields found in the supplied schema.

This is an educational lab project, not a production deployment. It has no user authentication or role permissions because those are not part of the supplied exam instructions. Do not expose it to the public internet as-is.
