# DESAFIO BACKEND

## Sobre o teste

O objetivo do teste é avaliar minhas habilidades como programador **backend PHP**, utilizando o Docker.

## 🚀 Como iniciar o projeto

Para começar, é necessário clonar este repositório na sua máquina local. Execute o seguinte comando no terminal:

- git clone https://github.com/omarcus212/teste-backend-estagio
- cd teste-backend-estagio

## Configure as variáveis de ambiente e arquivos de configuração

- Antes de subir o ambiente, você precisará configurar as variáveis de ambiente:

* Crie um arquivo .env na raiz do projeto.
* Utilize o arquivo .env.example como base, ele já possui as variáveis definidas para facilitar o - processo.
* Atualize também os arquivos docker-compose.yml e phinx.yml com as informações do seu banco de dados, utilizando as variáveis que você definiu no .env.
* ⚠️ Importante: Verifique se todas as variáveis de ambiente estão corretas antes de seguir para o próximo passo.

## Suba os containers com Docker

- docker-compose up --build -d

## Execute as migrations

- docker-compose run --rm api composer migrate
- Certifique-se de que todas as migrations foram executadas corretamente.

### Migrations

- Funcionalidades que exijam modificações no banco de dados (seja nos dados ou estrutura) **devem estar contidas em _migrations_**, não enviadas diretamente com o banco;
- **Seu arquivo de banco** `db.sqlite3` **não será utilizado para avaliação** do teste, por isso é importante persistir mudanças necessárias em migrations;
- A biblioteca utilizada para migrations foi o [**_Phinx_**](https://book.cakephp.org/phinx/0/en/index.html);
- As migrations criadas **devem poder ser revertidas** (método `down()`);
- Para interagir com as migrations, você pode usar os seguintes comandos:
- - Criar nova migration: `docker-compose run --rm api composer create-migration`
- - Rodar migrations: `docker-compose run --rm api composer migrate`
- - Reverter migration: `docker-compose run --rm api composer rollback`

## Sobre a API

- Deve ser utilizado o Postman para desenvolvimento e documentação, o arquivo para importação das rotas se encontra em docs/Teste estagio PHP.postman\*collection.json
- voce pode acessar https://documenter.getpostman.com/view/21065723/2sAYkGMLBS para ver a documentação da api e rotas.

> [!WARNING]

- É importante que se adicione o header admin_user_id com o id do usuário desejado ao acessar as rotas para simular o uso de um usuário no sistema.

### Alterações

Foi adicionada uma nova rota de **delete** na API de Produtos, responsável por **deletar permanentemente** o produto. Ao utilizar essa rota, o produto será removido de forma definitiva, inclusive das outras rotas relacionadas.

Além disso, o antigo endpoint de `DELETE` foi alterado para a rota `remove`. Agora, ao utilizar o `remove`, o produto **não é mais excluído do banco**, apenas é **desativado**, permanecendo registrado para fins de histórico e log.

### 📌 Resumo das mudanças:

- Seção de produto

* **DELETE `/products/delete/id`** → Remove o produto permanentemente de todas as rotas.
* **DELETE `products/remove/id`** → Apenas desativa o produto, mantendo-o salvo no banco e acessível para histórico.

Essas mudanças permitem maior controle sobre a exclusão dos produtos, oferecendo a opção de desativação sem perda de dados.

- Seção de comentários

* **INSERT `/comments/product/id`** → insere um comentario no produto, id = id do produto que deseja comentar.
* **INSERT `/comments/reply/id`** → insere um comentario em um comentario existente de um produto, id = id do comentario que deseja responder.
* **GET `/comments/product/id`** → busca por comentario feito em um produto, id = id do produto que deseja buscar.
* **DELETE `/comments/id`** → deleta o comentario feito no produto.

- Seção de likes

* **GET `/comments/likes/id`** → busca pelos likes feitos no comentarios, id = id do comentario que deseja buscar
* **INSERT `/comments/like/id`** → deixa o like no comentario desejado, id = id do comentario.

### ✅ Pronto!
Após finalizar as migrations, a API estará pronta para uso!
