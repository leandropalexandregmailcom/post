Crie um banco de dados chamado post. 
Renomeie o arquivo .env.example e configure a conexão com o banco que você criou.
Execute o comando: composer install
Caso necessário, rode o comando: php artisan key:generate
Rode o comando: php artisan migrate
Rode o comando: php artisan serve
Após esses passos, o servidor estará disponível na url http://127.0.0.1:8000 

Você poderá testar as apis direto pelo link abaixo, além de poder utilizar algum programa para testa-las, como por exemplo o Postman.
Api de documentação do projeto: http://127.0.0.1:8000/api/documentation

Alguns detalhes do projeto:
- As apis seguem o padrão restfull;
- Foi utilizado formRequest para fazer as validações dos inputs;
- Foi implementado um método observer nativo do laravel para observar a criação de posts;
- O projeto utiliza autenticação jwt.
- Foi criado uma fila, mas, não a utilizei.

Para qualquer dúvida, entre em contato pelo email leandro.p.alexandre@gmail.com
