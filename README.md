# Laravel 8 Project

This is a Laravel 8 project that aims to provide a CRUD (Create, Read, Update, Delete) system for managing states. It is built using the Laravel framework and follows the Laravel Breeze template for authentication.

## Project Description

The project focuses on creating a user-friendly interface for managing state records. It allows users to perform basic CRUD operations on state data, including adding new states, viewing existing states, updating state information, and deleting states.

The project includes the following key features:
- User authentication using Laravel Breeze for secure access to the CRUD system.
- A dashboard view to display the list of states and provide options for editing and deleting states.
- Form validation to ensure the accuracy and completeness of the state data.
- Integration with a free IP Geolocation API to restrict access to the CRUD system based on the user's country of origin.
- Real-time updates using AJAX requests to provide instant updates on state modifications without page reloads.
- Secure password hashing using the bcrypt algorithm provided by Laravel's Hash facade.

## Installation

To run the project locally, follow these steps:

1. Clone the repository to your local machine.
2. Install the project dependencies by running the `composer install` command.
3. Create a new MySQL database and update the `.env` file with your database and IPStack API credentials.
4. Generate an application key by running the `php artisan key:generate` command.
5. Migrate the database by running the `php artisan migrate` command.
6. Start the development server by running the `php artisan serve` command.
7. Compile the CSS and JS files via webpack.mix.js by running the `npm run development` command.

## Usage

Once the development server is running, you can access the project by visiting `http://localhost:8000` in your web browser. If you're not logged in, you'll be redirected to the login page. You can create a new account or use the default account provided by Laravel Breeze. After logging in, you'll be redirected to the dashboard where you can manage the states.

Local 127.0.0.1 Exclude from the IP restriction logic for development needs
this conditional can be removed before deployed to public live servers.

## Contributing

Contributions to this project are welcome! If you have any suggestions, bug reports, or feature requests, please feel free to open an issue or submit a pull request.

## License

This project is open-source and released under the [MIT License](LICENSE).
