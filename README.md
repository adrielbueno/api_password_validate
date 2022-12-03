## Introdução
Esse projeto consiste na realização de uma prova de backend em php.

## Configuração para executar o projeto

Depois de clonar o projeto verifique se você possui o composer instalado, caso não tenha o mesmo se encontra em:

**https://getcomposer.org/download/**

Após baixar e instalar, vá para o diretório do projeto execute o comando no terminal para rodar o composer:

**composer install**

Caso ja tenha o composer instalado basta executar o comando:

**composer update**


# XAMPP

Para simular um wervidor web localmente precisaremos do XAMPP ou outro software similiar. Com ele será possível executar o apache e criar o banco de dados.
Basta instalar normalmente e inicializar os serviços MySQL e Apache.

**https://www.apachefriends.org/download.html**

## Estrutura do projeto:

#### /
Contém os arquivos iniciais do projeto, tais como index.php, .htaccess e configurações do git.

#### /app
Nela temos configurações do projeto, controllers, core, módulos e rotas
	**/app/controller:** Contém os controllers da aplicação. São os responsáveis pelas entradas e saídas da API.  
	**/app/core:** Contém a base do projeto como configurações, handlers e classes de utilidade.  
		**/app/core/handlers/exceptions:** Tratamento de exceptions capturadas (catch);  
		**/app/core/handlers/middlewares:** Validações de middlewares;  
		**/app/core/handlers/request:** Tratamento das requests recebidas;  
		**/app/core/handlers/response:** Tratamento das responses do sistema;  
		**/app/core/handlers/router:** Ferramenta para gerenciamento das rotas;  
		**/app/core/utils:** Classes de utilidade;  
	**/app/modules:** Contém as mensagens de sucesso e erro do sistema. As mensagens são separadas em pastas relacionadas aos seus respectivos módulos, tais como usuário, transação, pagamentos e etc.  
	

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

# Documentação

Para ver os recursos utilizados e soluções adotadas no projeto consulte a documentação:

**docs/Documentacao.pdf**