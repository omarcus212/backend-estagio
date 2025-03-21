# DESAFIO BACKEND

## Sobre o teste

O objetivo do teste é avaliar suas habilidades como programador **backend PHP**.

Você receberá uma aplicação que necessita de ajustes descritos pelo cliente e correções de bugs apontadas, deve resolvê-los com a maior qualidade e organização de código possível. Serão avaliados: domínio da linguagem, resolução de problemas, performance, segurança e organização.

Existe uma seção ao fim do _README_ chamada **"Suas Respostas, Dúvidas e Observações"** reservada para documentação do processo de desenvolvimento, mudanças na API e lógica também devem ser documentadas.

## Configuração do Ambiente

### Requisitos e subindo o ambiente

- O único requisito necessário para o projeto é [Docker](https://www.docker.com/)
- O comando `docker-compose up --build -d` sobe a applicação na porta `8000`

## Sobre a entrega

> [!CAUTION]
> A entrega deve ser realizada em um repositório **_PRIVADO_** do **GitHub**;
>
> Você deve adicionar os usuários [`pedrosobucki`](https://github.com/pedrosobucki) e [`aloefflerj`](https://github.com/aloefflerj) como colaboradores do repositório com permissão de leitura para que seu teste possa ser avaliado.

- A primeira etapa é realizar um commit inicial com o código sem nenhuma modificação;
- As modificações devem estar separadas por commits coerentes com as funcionalidades e mudanças realizadas ao longo do processo, não um único commit com todas as modificaçẽs;
- As soluções elaboradas e implementadas por você devem ser apresentadas na seção **Suas Respostas, Dúvidas e Observações** ao fim do _README_.

## Sobre o Projeto

- O cliente XPTO Ltda. contratou seu serviço para realizar alguns ajustes em seu sistema de cadastro de produtos;
- O sistema permite o cadastro, edição e remoção de _produtos_ e _categorias de produtos_ para uma _empresa_;
- Para que sejam possíveis os cadastros, alterações e remoções é necessário um usuário administrador;
- O sistema possui categorias padrão que pertencem a todas as empresas, bem como categorias personalizadas dedicadas a uma dada empresa. As categorias padrão são: (`clothing`, `phone`, `computer` e `house`) e **devem** aparecer para todas as _empresas_;
- O sistema tem um relatório de dados dedicado ao cliente.

## Sobre a API

As rotas estão divididas em:

- _CRUD_ de _categorias_;
- _CRUD_ de _produtos_;
- Rota de busca de um _relatório_ que retorna um _html_.

Deve ser utilizado o [Postman](https://www.postman.com/) para desenvolvimento e documentação, o arquivo para importação das rotas se encontra em `docs/postman-api.json`.

> [!WARNING]
> É importante que se adicione o _header_ `admin_user_id` com o id do usuário desejado ao acessar as rotas para simular o uso de um usuário no sistema.

A documentação da API se encontra na pasta `docs/api-docs.pdf`

- A documentação assume que a url base é `localhost:8000` mas você pode usar qualquer outra url ao configurar o servidor;
- O _header_ `admin_user_id` na documentação está indicado com valor `1` mas pode ser usado o id de qualquer outro usuário caso deseje (_pesquisando no banco de dados é possível ver os outros id's de usuários_).

## Sobre o Banco de Dados

- O banco de dados é um _sqlite_ simples e já vem com dados preenchidos por padrão no projeto;
- O banco tem um arquivo de backup em `db/db-backup.sqlite3` com o estado inicial do projeto caso precise ser "resetado".

### Migrations

- Funcionalidades que exijam modificações no banco de dados (seja nos dados ou estrutura) **devem estar contidas em _migrations_**, não enviadas diretamente com o banco;
- **Seu arquivo de banco** `db.sqlite3` **não será utilizado para avaliação** do teste, por isso é importante persistir mudanças necessárias em migrations;
- A biblioteca utilizada para migrations foi o [**_Phinx_**](https://book.cakephp.org/phinx/0/en/index.html);
- As migrations criadas **devem poder ser revertidas** (método `down()`);
- Para interagir com as migrations, você pode usar os seguintes comandos:
- - Criar nova migration: `docker-compose run --rm api composer create-migration`
- - Rodar migrations: `docker-compose run --rm api composer migrate`
- - Reverter migration: `docker-compose run --rm api composer rollback`

# Demandas

Abaixo, as solicitações do cliente:

## Alterações

Modificações requisitadas pelo cliente em funcionalidades já existentes

### Categorias

- [x] A categoria está vindo errada na listagem de produtos para alguns casos (_exemplo: produto `blue trouser` está vindo na categoria `phone`_);
- [x] Alguns produtos estão vindo com a categoria `null` ao serem pesquisados individualmente (_exemplo: produto `iphone 8`_);
- [x] Cadastrei o produto `king size bed` em mais de uma categoria, mas ele aparece **apenas** na categoria `furniture` na busca individual do produto.

### Filtros e Ordenamento

Para a listagem de produtos:

- [x] Gostaria de poder filtrar os produtos ativos ou inativos;
- [x] Gostaria de poder filtrar os produtos por categoria;
- [x] Gostaria de poder ordenar os produtos por data de cadastro.

### Relatório

- [x] O relatório não está mostrando a coluna de logs corretamente, se possível, gostaria de trazer no seguinte formato:
      (Nome do usuário, Tipo de alteração e Data),
      (Nome do usuário, Tipo de alteração e Data),
      (Nome do usuário, Tipo de alteração e Data)
      Exemplo:
      (John Doe, Criação, 01/12/2023 12:50:30),
      (Jane Doe, Atualização, 11/12/2023 13:51:40),
      (Joe Doe, Remoção, 21/12/2023 14:52:50)

### Logs

- [x] Gostaria de saber qual usuário mudou o preço do produto `iphone 8` por último.

### Correção de bug

- [x] Ao rodar os teste unitários com `composer test` são apontados erros. Eles precisam ser resolvidos, com documentação sobre a causa e a solução.

## Features

Novas funcionalidades requisitadas pelo cliente

> [!WARNING]
> Preste atenção, funcionalidades que exijam mudanças no banco de dados devem conter tais modificações em uma ou mais **migrations**.

### Comentários

Quero que os usuários do sistema possam discutir sobre os produtos em uma área de comentários.

Para isso, novas rotas devem ser criadas:

- [x] Criar um novo comentário no produto
- [x] Responder um comentário já realizado (todo comentário pode ser diretamente respondido)
- [x] Remover um comentário feito por mim
- [x] Curtir um comentário
- [x] Listar todos os comentários de um produto em um objeto com hierarquia de comentários

## Features extras

As seguintes features não são sua prioridade, mas sinta-se livre para implementa-las caso esteja apto ao desafio.

### Traduções

- [ ] Quero disponibilizar meu sistema para fora do país, crie uma funcionalidade de cadastro de traduções para as categorias que segue o seguinte contrato:

```
POST "$base_url/categories/:id"

{
  "translations": [
    {
      "lang_code": "en",
      "label": "home"
    },
    {
      "lang_code": "pt",
      "label": "casa"
    }
  ]
}
```

- [ ] Não deve ser possível cadastrar traduções repetidas, se uma única tradução repetida foi enviada, nenhuma deve persistir;
- [ ] Ao buscar por produtos/categorias, o parâmetro adicional opcional "_`lang`_" pode ser passado para determinar a linguagem em que a categoria deve ser retornada;
- [ ] Caso não haja categoria correspondente ou não seja especificado por parâmetro, retornar em inglês;
- [ ] Inclua a rota e as modificações na coleção do Postman no repositório.

### Estoque

Além das informações já disponíveis do produto, desejo acrescentar também uma contagem de estoque para cada, a qual deve seguir algumas regras:

- [ ] Posso cadastrar a quantidade do estoque assim que cadastro um produto, mas se não for informado assumo que o estoque é _0_;
- [ ] Posso atualizar o estoque de um produto;
- [ ] Ao buscar um produto, posso filtrar por uma quantidade mínima em estoque.

##

**Seu trabalho é atender às demandas solicitadas pelo cliente.**

Caso julgue necessário, podem ser adicionadas ou modificadas as rotas da api. Caso altere, por favor, explique o porquê e indique as alterações nesse `README`.

Sinta-se a vontade para refatorar o que achar pertinente, considerando questões como arquitetura, padrões de código, padrões restful, _segurança_ e quaisquer outras boas práticas. Levaremos em conta essas mudanças.

## Docker

> [!WARNING]
> Esta etapa é opcional, sinta-se a vontade para mostrar sua proficiência com docker fazendo modificações e aplicando novas estruturas que achar pertinente. Abaixo estão listadas algumas sugestões de modificações.

### Desafios

- [x] Substituir o banco serverless **SQLite** por um banco como **MySQL**/**PostgreSQL**/outro e servir por container;
- [x] Escrever **novos testes unitários** para funcionalidades faltantes;
- [ ] Implementar um **Linter** e disponibilizar por docker (especificar comando);
- [ ] Implementar **análise estática** e disponibilizar por docker (especificar comando);
- [ ] Escrever um script "_`check_deploy.sh`_" que faz todas as validações implementadas como uma pipeline e determina se o código está pronto para produção.

## Suas Respostas, Dúvidas e Observações

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
