# 📒 Back-end da aplicação Contact Book

###

<br>

Este projeto é uma API de Agenda de Contatos desenvolvida com o framework PHP Laravel 11 em um ambiente Docker. A aplicação permite adicionar, deletar, buscar e visualizar contatos, validando os dados fornecidos, como nome, telefone, e-mail e CEP. O CEP é validado através da API pública ViaCEP. A aplicação oferece um ponto de integração REST que pode ser consumido por sistemas externos.

Para uma experiência completa, siga o passo a passo abaixo para configurar o ambiente e iniciar o servidor.

<br>

## Tecnologias

Este projeto utiliza as seguintes tecnologias:

- **PHP 8.3** com framework **Laravel 11**;
- **PostgreSQL** como banco de dados relacional;
- **ViaCEP API** para validação e preenchimento automático de endereços;
- **Docker** como uma ferramenta de containerização;

<br>

## Funcionalidades
### Contatos:
- Adicionar novos contatos com nome, telefone, e-mail e CEP.
- Validação e preenchimento automático do endereço utilizando o CEP e a API ViaCEP.
- Filtros avançados para busca de contatos por `nome` e `e-mail`.
- Deletar um contato.

<br>

## Configuração do Projeto

### Requisitos para rodar a aplicação

Para rodar este projeto, é necessário ter os seguintes softwares instalados:

- **Docker**: https://docs.docker.com/get-docker/
- **Docker Compose**: https://docs.docker.com/compose/install/

### Instalação

1. Clonando o repositório:

```bash
$ git clone git@github.com:rafittu/back-contact-book.git
$ cd back-contact-book
```

2. Crie um arquivo `.env` na raiz do projeto e preencha as informações de acordo com o arquivo `.env.example` disponível.

3. Inicie o ambiente de desenvolvimento:

```bash
$ docker-compose up --build
```

4. Após iniciar o ambiente, entre no container e instale as dependências do Laravel:

```
$ docker-compose exec app bash
$ composer install
```

5. Rodar as migrações do banco de dados:

```
$ php artisan migrate
```

6. Gerar a chave da aplicação:

```
$ php artisan key:generate
```

<br>

## Endpoints Principais
### Contatos:

- **`POST /api/contacts`:** Criar um novo contato;
```
{
  "name": "John Doe",
  "phone": "123456789",
  "email": "johndoe@example.com",
  "cep": "01001000"
}
```

- * **Resposta**:
 
```
{
  "id": "uuid",
  "name": "John Doe",
  "phone": "123456789",
  "email": "johndoe@example.com",
  "address": {
    "id": "uuid",
    "cep": "01001000",
    "street": "Praça da Sé",
    "neighborhood": "Sé",
    "city": "São Paulo",
    "state": "SP"
  },
  "created_at": "2024-10-22T10:00:00.000000Z",
  "updated_at": "2024-10-22T10:00:00.000000Z"
}
```

- **`GET /api/contacts`:** Lista todos os contatos, com opções de filtro por `nome` e `e-mail`;
  1. Filtros devem ser usados como query nas requisições. Opções disponíveis:
     - `name`: Filtrar contatos pelo nome.
     - `email`: Filtrar contatos pelo e-mail.

- * **Resposta**:

```
{
  "data": [
    {
      "id": "uuid",
      "name": "John Doe",
      "phone": "123456789",
      "email": "johndoe@example.com",
      "address": {
        "id": "uuid",
        "cep": "01001000",
        "street": "Praça da Sé",
        "neighborhood": "Sé",
        "city": "São Paulo",
        "state": "SP"
      },
      "created_at": "2024-10-22T10:00:00.000000Z",
      "updated_at": "2024-10-22T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/contacts?page=1",
    "last": "http://localhost:8000/api/contacts?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http://localhost:8000/api/contacts",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

- **`DELETE /api/contacts/{id}`:** Deleta um contato específico;
  1. Parâmetro:    
     - `id`: UUID do contato a ser deletado.
    
- * **Resposta**:

```
{
    message: Contato deletado com sucesso
}
```

<br>

##

<p align="right">
  <a href="https://www.linkedin.com/in/rafittu/">Rafael Ribeiro 🚀</a>
</p>
