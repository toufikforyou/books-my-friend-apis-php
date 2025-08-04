# Books My Friend APIs (PHP Script)

A simple and easy-to-use API for managing books. This project provides a complete backend solution for a book management system.

## Features

*   User authentication (Sign up, Login)
*   OTP verification
*   Create, Read, Update, Delete (CRUD) operations for books
*   View user's own books
*   Secure API with token-based authentication

## API Endpoints

The base URL for the API is `https://api.console.booksmyfriend.app/`

| Endpoint                  | Method | Description              | Authentication |
| ------------------------- | ------ | ------------------------ | -------------- |
| `/signup`                 | POST   | Create a new user        | None           |
| `/login`                  | POST   | Login a user             | None           |
| `/verify-otp`             | POST   | Verify OTP               | None           |
| `/books`                  | POST   | Create a new book        | Token          |
| `/my-books`               | GET    | Get user's own books     | Token          |

## Installation

1.  Clone the repository:
    ```bash
    git clone https://github.com/toufikforyou/books-my-friend-apis-php.git
    ```
2.  Install dependencies using Composer:
    ```bash
    composer install
    ```
3.  Set up your database and configure the database credentials in `services/Database/SLDatabase.php` and `services/Database/SLWDatabase.php`.
4.  Your API is ready to use!

## Usage

You can use any API testing tool like Postman or integrate the APIs into your application.

## Contributing

Contributions are welcome! Please read the [contributing guidelines](docs/contributing.md) before getting started.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

*   **MH Toufik** - *Initial work* - [toufikforyou](https://github.com/toufikforyou)
