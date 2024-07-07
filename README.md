# API Rest sample using PHP and Swoole

## About this project

This is a simple REST API for user authentication using JWT and basic user manipulation. Built with PHP, Swoole and following the principles of Clean Architecture.

## Project Structure

```plaintext
├── src/
│   ├── Domain/
│   │   ├── Entities/
│   │   │   └── User.php
│   │   ├── Repositories/
│   │   │   └── IUserRepository.php
│   ├── Application/
│   │   ├── Services/
│   │   │   └── UserService.php
│   ├── Infrastructure/
│   │   ├── Repositories/
│   │   │   └── UserRepository.php
│   │   ├── Persistence/
│   │   │   └── Database.php
│   ├── Api/
│   │   ├── Controllers/
│   │   │   └── UserController.php
│   │   │   
├── public/
│   ├── index.php
│   ├── swagger.php
├── tests/
│   ├── Unit/
│   ├── Integration/
└── .env
```

### Description of Folders

- **src/Domain**:
  - **Entities**: Contains business entities that are domain objects with basic business rules.
    - `User.php`: Represents the user entity.
  - **Repositories**: Defines interfaces for repositories.
    - `IUserRepository.php`: Interface that defines methods for persisting user data.

- **src/Application**:
  - **Services**: Contains the application logic that orchestrates operations between domain entities and repositories.
    - `UserService.php`: Service responsible for user registration and search logic.

- **src/Infrastructure**:
  - **Repositories**: Implements the repository interfaces defined in the domain.
    - `UserRepository.php`: Concrete implementation of the repository interface using PDO.
  - **Persistence**: Configuration and connection to the database.
    - `Database.php`: Singleton connection to the database.

- **src/Api**:
  - **Controllers**: Handles HTTP requests, calling the appropriate application services and returning responses.
    - `UserController.php`: Controller that handles user-related HTTP requests.

- **src/config**:
  - `config.php`: Project dependencies configuration file.

- **public**:
  - `index.php`: Input file that initializes the Swoole Server.
  - `swagger.php`: File to generate Swagger JSON documentation.

- **tests**:
  - `Unit/`: Folder for unit tests.
  - `Integration/`: Folder for integration tests.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/antonielbordin/restapi-swoole.git
   cd restapi-swoole
   ```

2. Install dependencies using Composer:
   ```bash
   composer install
   ```

3. Configure your database in the file `.env`:
   ```
   DB_HOST=localhost
   DB_NAME=testdb
   DB_USER=username
   DB_PASS=password
   ```

4. Configure dependencies in the file `src/config/config.php`.

## Use

### Endpoints

- **Register User**
  - **POST /users**
  - Request Body:
    ```json
    {
      "name": "John Doe",
      "login": "johndoe",
      "password": "password123"
    }
    ```
  - Response:
    - `201 Created`: User created successfully.
    - `400 Bad Request`: Invalid input.

- **Search User by Login**
  - **GET /users/{login}**
  - Response:
    - `200 OK`: User found.
    - `404 Not Found`: User not found.

## Tests

Tests can be run using PHPUnit. Make sure you configure the tests in the `test` directory.

To run the tests:
```bash
vendor/bin/phpunit
```

## Contribution

1. Fork the project.
2. Create a branch for your feature (`git checkout -b feature/new-feature`).
3. Commit your changes (`git commit -am 'Adds new feature'`).
4. Push to branch (`git push origin feature/new-feature`).
5. Create a new Pull Request.

## Licença

This project is licensed under the MIT License - view the file [LICENSE](LICENSE) for more details. 
