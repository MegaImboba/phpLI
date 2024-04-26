# MineAndCraft

## Table of Contents
1. [Installation Guide](#installation-guide)
2. [Laboratory Work Description](#laboratory-work-description)
3. [Documentation](#documentation)
   - [Functionalities](#functionalities)
   - [User Interaction Scenarios](#user-interaction-scenarios)
   - [Database Structure](#database-structure)
4. [Examples of Usage](#examples-of-usage)
5. [FAQ](#faq)
6. [References](#references)
7. [Additional Notes](#additional-notes)

## Installation Guide
To set up and run the project locally, follow these steps:

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer (for dependency management)

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/MegaImboba/phpIL.git
   cd yourprojectname
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure your database connection in `config.php`:
   ```php
   $dbHost = 'localhost';
   $dbUser = 'root';
   $dbPassword = '';
   $dbName = 'myapp';
   ```
4. Import the SQL file to setup your database:
   ```bash
   mysql -u root -p myapp < Data/myapp.sql
   ```
5. Start your PHP server:
   ```bash
   php -S localhost:8000
   ```
6. Open `http://localhost:8000` in your web browser.

## Laboratory Work Description
This project is a web application designed as part of a web development course to demonstrate fundamental and advanced techniques in building secure, robust, and user-friendly web applications.

## Documentation

### Functionalities
- **User Authentication**: Users can register, login, and logout.
- **Message Posting**: Any logged-in user can post messages limited to 2000 characters.
- **Admin Moderation**: Administrators can edit or delete messages posted by users.

### User Interaction Scenarios
- **Registration**: Users provide a username and password to register. The username must not exceed 30 characters, and the password must be between 4 and 20 characters.
- **Posting Messages**: Once logged in, users can post messages up to 2000 characters. There is a daily limit of 20 messages per user.
- **Admin Moderation**: Administrators can view all messages and perform actions like edit or delete directly from the admin dashboard.

### Database Structure
- **users**: `id (PK)`, `username`, `password_hash`, `is_admin`
- **messages**: `id (PK)`, `user_id (FK)`, `message`, `timestamp`

## Examples of Usage
### Registering a New User
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Validation and registration logic here
}
```
### Posting a Message
```php
if (loggedIn() && $_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    // Posting logic here
}
```

## FAQ
**Q1:** What technologies does the project use?
**A1:** The project uses PHP, MySQL, and JavaScript.

**Q2:** How do I reset my password?
**A2:** Currently, password reset functionality is not implemented. This could be a future enhancement.

## References
- PHP Manual: https://www.php.net/manual
- MySQL Documentation: https://dev.mysql.com/doc/
- Offical site Minecraft: https://minecraft.com/

## Additional Notes
- Ensure your PHP and MySQL installations are up to date to avoid compatibility issues.
- Review PHP security best practices to ensure the application is secure against common vulnerabilities.
