## Buzzvel Vacation Test - Anataniel Diogo

Esta api foi desenvolvida utilisando o framework [Laravel](https://laravel.com/) v11. 


## Como rodar o projecto

Para rodar o Projecto você precisa ter o Laravel e o Mysql instalado na sua máquina e bem configurado.

Após a configuração do Laravel e Mysql, abra o seu terminal e faça o clone do projecto:

      $ git clone https://github.com/anatanieldiogo/buzzvel.git

 Depois, acessar o diretório do projecto(buzzvel) pelo terminal e seguir os passos:


Instalar as dependências
    
    $ composer install

Ou caso o comando acima apresentar um erro sobre a atualização das dependências:
    
    $ composer update

Copiar o arquivo .env

    $ cp .env.example .env

Gerar a chave da aplicação

    $ php artisan key:generate

Configurar o banco de dados no arquivo .env copiado acima:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE= nome_do_banco_de_dados(ex: Buzzvel)
    DB_USERNAME= nome_de_usuario_do_mysql(ex: root)
    DB_PASSWORD= caso_tenha_colocar_a_palavra_passe

Feito isso podemos rodar o projeto:

    $ php artisan serve

Rodar as migrations para criar as tabelas no banco de dados:

    $ php artisan migrate

## Seeders

De antemão preparei dois usuários e respetivos holidays criados por eles, serão inseridas no DB automaticamente utilizando seeders, e para tal devemos rodar o comando:

    $ php artisan migrate:fresh --seed

Ou

    $ php artisan db:seed

Como rodar uma [Seeder](https://laravel.com/docs/9.x/seeding#running-seeders)

## Usuários

- anataniel@gmail.com
- carlos@gmail.com

Ambos com a senha: `password`


## Endpoints

Para testar o funcionamento correto dos endpoints aconselho a utilização do [Postman](https://www.postman.com/) ou de outra ferramenta a sua escolha!

Os endpoints são protegidos por um token `sanctum` exceto(/login), gerado após a autenticação, e o mesmo é do tipo `Bearer Token` e, deve ser usado nos seguintes endpoints:

- http://127.0.0.1:8000/api/holidays/ `GET`
- http://127.0.0.1:8000/api/holidays/ `POST`
- http://127.0.0.1:8000/api/holidays/ `holiday_id` `PUT`
- http://127.0.0.1:8000/api/holidays/ `holiday_id` `DELETE`
- http://127.0.0.1:8000/api/export/holiday/ `holiday_id` `GET`
- http://127.0.0.1:8000/api/auth/logout `GET`

configurar o token no Postman [Bearer Token](https://www.youtube.com/watch?v=PPi9teNKRHY)

## Endpoints - descrição

**Login**

`http://127.0.0.1:8000/api/auth/login` `POST`


Este endpoint é reponsavel pela autenticação dos usuários e deve receber os seguintes parametros:

- email
- password

Retorna:

    {
        "accessToken": "TOKEN_HASH",
        "token_type": "Bearer"
    }
    
O valor do `accessToken` deve ser inserido no header nos demais endpoints para a autorização.

**Listar holiday**

`http://127.0.0.1:8000/api/holidays/` `GET`

Este endpoint retorna todos os holidays do usuário autenticado (sem parametro), retorna:

    {
        "is_success": true,
        "data": [
            {
                "id": ...,
                "title": "...",
                "description": "...",
                "date": "...",
                "location": "...",
                "user": {
                    "name": "holiday_owner_name"
                }
            },
            ...
        ]
    }

**Criar holiday**

`http://127.0.0.1:8000/api/holidays/` `POST`

Este endpoint cria um holiday e tem os seguintes parametros:

- title
- description
- date
- location

Retorna:

    {
        "is_success": true,
        "data": {
            "id": ...,
            "title": "...",
            "description": "...",
            "date": "...",
            "location": "...",
            "user": {
                "name": "..."
            }
        },
        "message": "Holiday Created Successful"
    }

**Atualizar holiday**

`http://127.0.0.1:8000/api/holidays/` `holiday_id` `PUT`


Este endpoint atualiza um holiday especifico e tem como parametros:

- title
- description
- date
- location
- `_method`
    
OBS: Apesar de ser PUT muitas vezes esse método não funciona em alguns softwares como no POSTMAN, para isso devemos colocar como POST e adicionar o parametro `_method` com o valor PUT.

Retorna:

    {
        "is_success": true,
        "data": "Holiday Updated Successful"
    }

**Apagar holiday**

`http://127.0.0.1:8000/api/holidays/` `holiday_id` `DELETE`


Este endpoint deleta um holiday especifico (sem parametro), retorna:

    {
        "is_success": true,
        "data": "Holiday Deleted Successful"
    }

**Logout**
    
`http://127.0.0.1:8000/api/auth/logout` `GET`


Este endpoint termina a secção do usuário (sem parametro), retorna:

    {
        "message": "You are logged out!"
    }
    
**Exportar pdf**
    
`http://127.0.0.1:8000/api/export/holiday/` `GET`


Este endpoint retorna uma arquivo .pdf.

**OBS:** Note que não é possível um usuário visualizar ou alterar as informações de outros usuários.

## Testes

Para rodar os testes unitários basta executar o comando:

    $ php artisan test --testsuite=Feature

Ou

    $ ./vendor/bin/phpunit --testsuite=Feature

Caso preferir, pode rodar os teste no ambiente sqlite alterando o arquivo `phpunit.xml` na raíz do projeto:

    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>

Para um melhor desempenho durante os testes.

**NOTA:** Se por algum motivo não for possível executar o sistema porfavor entrar em contato!
