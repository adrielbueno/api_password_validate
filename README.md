# API Conta Digital Eaglecred

> Usa PHP 7.4

## Repositórios

* Webpj: https://gitlab.totvs.amplis.com.br/rbm/conta_digital/webpj/webpj_contadigital_eaglecred
* Admin: https://gitlab.totvs.amplis.com.br/rbm/conta_digital/admin/admin_contadigital_eaglecred_reactjs

## Ambientes

Ambiente | API | Banco Conta Digital | Banco Webcred
--- | --- | --- | ---
Desenvolvimento | https://eaglecred.apiconta.devrbm.top | eaglecred_contadigital_teste (WEB-07) | eaglecred_webcred_teste (WEB-07)
Homologação | https://eaglecred.apiconta.rbmweb.link | eaglecred_contadigital_homolog (WEB-12) | eaglecred_webcred_teste (WEB-07)
Produção | https://eaglecred.apiconta.aplicativo.digital | eaglecred_contadigital (WEB-12) | eaglecred_webcred (WEB-12)
Canário | https://eaglecred.apicanary.aplicativo.digital | eaglecred_contadigital (WEB-12) | eaglecred_webcred (WEB-12)

### Servidores de bancos de dados

Nome | IP | Tipo
--- | --- | ---
WEB-07 | 177.184.16.52 | Desenvolvimento
WEB-12 | 200.95.188.72 | Produção

## Estrutura do projeto:

#### /
Contém os arquivos iniciais do projeto, tais como index.php, .htaccess e configurações do git.

#### /app
Responsável pelas regras do projeto. Nela temos configurações do projeto, controllers, models, views, rotas, mensagens, conexão com outros serviços.
	**/app/assets:** Contém assets das views  
	**/app/controller:** Contém os controllers da aplicação. São os responsáveis por reunir as regras de negócio lidando com entradas e saídas da API.  
	**/app/core:** Contém a base do projeto como configurações, conexão com banco de dados, handlers, helpers e classes de utilizade.  
		**/app/core/handlers/curl:** Tratamento requisições curl;  
		**/app/core/handlers/exceptions:** Tratamento de exceptions capturadas (catch);  
		**/app/core/handlers/logs:** Escrita/leitura de arquivos de logs;  
		**/app/core/handlers/middlewares:** Validações de middlewares;  
		**/app/core/handlers/request:** Tratamento das requests recebidas;  
		**/app/core/handlers/response:** Tratamento das responses do sistema;  
		**/app/core/handlers/router:** Ferramenta para gerenciamento das rotas;  
		**/app/core/helpers:** Classes auxiliares;  
		**/app/core/utils:** Classes de utilidade;  
	**/app/messages:** Contém as mensagens de sucesso e erro do sistema. As mensagens são separadas em pastas relacionadas aos seus respectivos módulos, tais como usuário, transação, pagamentos e etc.  
	**/app/model:** Contém as models do sistema. São as responsáveis por gerenciar os dados. Idealmente, devemos ter uma model para cada tabela do banco de dados.  
	**/app/routes:** Contém os arquivos de rotas do sistema.  
	**/app/services:** Integrações utilizadas pelo sistema. Os módulos seguem a ideia do padrão de projeto [Factory Method](https://refactoring.guru/pt-br/design-patterns/factory-method "Factory Method") para abstrair as integrações das regras de negócio do sistema.  
	**/app/view** Contém as páginas HTML do sistema.

#### /docs
Guarda os arquivos relacionados à documentação, regras de negócio, collections e etc...

#### /fly
Biblioteca para exibição de imagens.

#### /img
Imagens de usuários

#### /logs
Arquivos de logs

#### /vendor
Pasta gerada automaticamente pelo composer

## Configurando o projeto:

A configuração do projeto está nos seguintes arquivos:  
**/app/core/config/dados-do-projeto.php**: configura variáveis globais referentes ao projeto do cliente;  
**/app/core/config/dominio.php**: configura variáveis globais referentes ao servidor do projeto;  
**/app/core/config/rotas-liberadas.php**: configura os arrays de rotas que não precisam de autenticação e rotas liberadas para terceiros (fluxo diferente para validação do token de autenticação);  
**/app/core/config/.env.php**: constantes de configuração do projeto tais como banco de dados e API's.

#### Executando o projeto localmente:
Para executar o projeto localmente é necessário configurar um arquivo **.env.php** na pasta **/app/core/config**. Para isso, existe um arquivo de exemplo **/app/core/config/.env.exemple.php** que contém as constantes necessárias no projeto.

## Padrões
### Rotas:
As rotas funcionam através das classes **RequestHandler**, **Route** e **Router**
As rotas são definidas conforme o exemplo:
```php
$router->post('/boleto/consultar', fn (RequestHandler $request) => (new BoletoController())->consultarDadosBoleto($request->getJson()));
```

Para executar middlewares, basta chamá-los pela função **before** ou **after** logo após a declaração da rota:
```php
$router->post('/exemple', fn (RequestHandler $request) => (new ExempleController())->executeSomething($request->getJson()))->before(new ExecuteBefore(["param" => "someParam"]));

$router->get('/exemple', fn (RequestHandler $request) => (new ExempleController())->executeSomething($request->getJson()))->after(new ExecuteAfter(["param" => "someParam"]));

$router->put('/exemple', fn (RequestHandler $request) => (new ExempleController())->executeSomething($request->getJson()))->before(new ExecuteBefore(["param" => "someParam"]))->after(new ExecuteAfter(["param" => "someParam"]));
```

### Retornos:
Tentando padronizar os retornos da API, desenvolvemos a classe **ResponseHandler** que disponibiliza os seguintes métodos públicos:
```php
ResponseHandler::json(string $cod, int $httpCode = 200, array $payload = []): string;
ResponseHandler::printJson(string $cod, int $httpCode = 200, array $payload = []): void;
ResponseHandler::getMessage(string $cod, array $payload = []): array;

/**
 * @deprecated Use a função printJson
 */
ResponseHandler::printMensagemJson(string $cod, array $payload = [], int $httpCode = 200);

/**
 * @deprecated Use a função getJson
 */
ResponseHandler::getJsonMensagem(string $cod, array $payload = [], int $httpCode = 200);
ResponseHandler::getJson(string $cod, int $httpCode = 200, array $payload = []): string;
ResponseHandler::notImplemented(): void;
ResponseHandler::noContentSuccess(): void;
```

As funções acima formatam o retorno para o seguinte formato:
```json
{
	"cod": "", // Código que define uma mensagem
	"retorno": "", // "sucesso"|"erro"
	"mensagem": "", // Mensagem referente ao código
	... // array com dados necessários no retorno
}
```

#### Exemplos:
Erro:
```json
{
    "cod": "E205-008",
    "retorno": "erro",
    "mensagem": "Pagamento já efetuado!",
    "endpoint": "boleto/solicitar_pagamento"
}
```

Sucesso:
```json
{
    "cod": "S205-001",
    "retorno": "sucesso",
    "mensagem": "Consulta realizada!",
    "error": false,
    "id": "464",
    "linhadigitavel": "836800000017641000403221833962320036100302539067",
    "codbarras": "836800000017641000403221833962320036100302539067",
    "valor": 164.1,
    "cedente": "Generica CC",
    "dataVencimento": null,
    "horaInicial": "07:00",
    "horaFinal": "21:00",
    "transactionId": 8315884,
    "tipo": 1
}

```

