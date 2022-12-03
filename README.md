# Introdução
Esse projeto consiste na realização de uma prova de backend em php.

# Configuração para executar o projeto

## Composer

Depois de clonar o projeto verifique se você possui o composer instalado, caso não tenha o mesmo se encontra em:

**https://getcomposer.org/download/**

Após baixar e instalar, vá para o diretório do projeto e execute o comando no terminal para rodar o composer:

**composer install**

Caso ja tenha o composer instalado basta executar o comando:

**composer update**

## XAMPP

Para simular um wervidor web localmente precisaremos do XAMPP ou outro software similiar. Com ele será possível executar o apache e criar o banco de dados.
Basta instalar normalmente e inicializar o serviço do Apache.

**https://www.apachefriends.org/download.html**

## Diretório

A pasta do projeto deve ficar na pasta htdocs. Se a instalação do XAMPP foi feita em um sistema windows, este será o repositório padrão:

**C:\xampp\htdocs**

Dependendo do diretório que for definido, a url usada no POSTMAN na hora de testar a requisição também deverá ser alterada. Nesse exemplo teriamos:

**http://localhost/api_password_validate/verify**

# Estrutura do projeto:

### /
Contém os arquivos iniciais do projeto, tais como index.php, .htaccess e configurações do git.

### /app
Nela temos configurações do projeto, controllers, core, módulos e rotas
	**/app/controller:** Contém os controllers da aplicação. São os responsáveis pelas entradas e saídas da API.  
	**/app/core:** Contém a base do projeto como configurações, handlers e classes de utilidade.  
		**/app/core/handlers/exceptions:** Tratamento de exceptions capturadas (catch);  
		**/app/core/handlers/middlewares:** Validações de middlewares;  
		**/app/core/handlers/request:** Tratamento das requests recebidas;  
		**/app/core/handlers/response:** Tratamento das responses do sistema;  
		**/app/core/handlers/router:** Ferramenta para gerenciamento das rotas;  
		**/app/core/utils:** Classes de utilidade;  
	**/app/routes:** Arquivo com endpoint das rotas;
	**/app/modules:** Tratativas específicas e segmentadas
	

### /docs
Guarda os arquivos relacionados à documentação como as collections.

### /vendor
Pasta gerada automaticamente pelo composer

### Rotas:
As rotas funcionam através das classes **RequestHandler**, **Route** e **Router**
As rotas são definidas conforme o exemplo:
```php
$router->post('/verify', fn (Request $request) => (new VerifyController())->validatePassword($request->getObj()));
```

### Retornos:
A classe **ResponseHandler** disponibiliza métodos para facilitar a tratativa de respostas da API:
```php
ResponseHandler::getJson(int $httpCode = 200, array $payload = []): string;
ResponseHandler::printJson(int $httpCode = 200, array $payload = []): void;
```

### Exemplo de entrada e saída:
Entrada:
```json
{
    "password": "TesteSenhaForte!123&",
    "rules": [
        {"rule": "minSize","value": 8},
        {"rule": "minSpecialChars","value": 2},
        {"rule": "noRepeted","value": 0},
        {"rule": "minDigit","value": 4}
    ]

}
```

Saída:
```json
{
    "verify": false,
    "noMatch": [
        "minDigit"
    ]
}
```

# Lógica de desenvolvimento
## Módulo PasswordRules

O módulo **/app/modules/PasswordRules** foi construído para tirar do controller a responsabilidade
de uma regra específica, além de facilitar a especialização da validação com a criação das classes Expressions, Types e Validation.

### Classe Expressions
Representa as expressões regulares que são usadas como parâmetro para validação das senhas
### Classe Types
Representa os tipos de regras definidas na prova para a senha.
### Classe Validation
Faz a validação. Na função **validatePasswordWithRules** foi usado o recurso de mapeamento dinâmico
para evitar muitos IFs. O array **DYNAMIC_MAPPING_RULES** relaciona o Type da regra com  o nome da
função e, na iteração do array de regras recebido no request, as funções são chamadas.

## Controller VerifyController
Esse controller ficou com a responsabilidade de receber os parâmetros para validação, chamar a função
principal do módulo PasswordRules, e tratar o retorno.
