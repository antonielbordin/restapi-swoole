
# User API

## Descrição

Esta é uma API RESTful simples para gerenciamento de usuários, construída usando PHP, Swoole e seguindo os princípios da Clean Architecture. A API permite operações básicas como registrar um novo usuário e buscar usuários pelo login.

## Estrutura do Projeto

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
│   ├── config/
│   │   └── config.php
├── public/
│   ├── index.php
│   ├── swagger.php
├── tests/
│   ├── Unit/
│   ├── Integration/
└── .env
```

### Descrição das Pastas

- **src/Domain**:
  - **Entities**: Contém as entidades de negócio que são objetos de domínio com regras de negócio básicas.
    - `User.php`: Representa a entidade de usuário.
  - **Repositories**: Define interfaces para os repositórios.
    - `IUserRepository.php`: Interface que define os métodos para persistência de dados de usuário.

- **src/Application**:
  - **Services**: Contém a lógica de aplicação que orquestra as operações entre as entidades do domínio e os repositórios.
    - `UserService.php`: Serviço responsável pela lógica de registro e busca de usuários.

- **src/Infrastructure**:
  - **Repositories**: Implementa as interfaces de repositório definidas no domínio.
    - `UserRepository.php`: Implementação concreta da interface de repositório usando PDO.
  - **Persistence**: Configuração e conexão ao banco de dados.
    - `Database.php`: Conexão singleton com o banco de dados.

- **src/Api**:
  - **Controllers**: Lida com as requisições HTTP, chamando os serviços de aplicação apropriados e retornando as respostas.
    - `UserController.php`: Controlador que lida com requisições HTTP relacionadas aos usuários.

- **src/config**:
  - `config.php`: Arquivo de configuração das dependências do projeto.

- **public**:
  - `index.php`: Arquivo de entrada que inicializa o framework Slim e define as rotas.
  - `swagger.php`: Arquivo para gerar a documentação JSON do Swagger.

- **tests**:
  - `Unit/`: Pasta para testes unitários.
  - `Integration/`: Pasta para testes de integração.

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. Instale as dependências usando o Composer:
   ```bash
   composer install
   ```

3. Configure seu banco de dados no arquivo `.env`:
   ```
   DB_HOST=localhost
   DB_NAME=testdb
   DB_USER=username
   DB_PASS=password
   ```

4. Configure as dependências no arquivo `src/config/config.php`.

## Uso

### Endpoints

- **Registrar Usuário**
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
    - `201 Created`: Usuário criado com sucesso.
    - `400 Bad Request`: Input inválido.

- **Buscar Usuário por Login**
  - **GET /users/{login}**
  - Response:
    - `200 OK`: Usuário encontrado.
    - `404 Not Found`: Usuário não encontrado.

### Documentação Swagger

Para visualizar a documentação da API:

1. Inicie o servidor local:
   ```bash
   php -S localhost:8080 -t public
   ```

2. Abra o Swagger UI e configure-o para apontar para `http://localhost:8080/swagger`.

## Testes

Os testes podem ser executados usando PHPUnit. Certifique-se de configurar os testes no diretório `tests`.

Para executar os testes:
```bash
vendor/bin/phpunit
```

## Contribuição

1. Fork o projeto.
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`).
3. Commit suas alterações (`git commit -am 'Adiciona nova feature'`).
4. Push para a branch (`git push origin feature/nova-feature`).
5. Crie um novo Pull Request.

## Licença

Este projeto está licenciado sob a MIT License - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
