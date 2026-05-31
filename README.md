# Gerenciamento de Produtos — Laravel 12

Aplicação web para gerenciamento de produtos com CRUD via interface web (Blade + Tailwind +
[starting-point-ui](https://startingpointui.com/)) e uma API RESTful versionada protegida por
autenticação. Desenvolvido com foco em boas práticas, arquitetura limpa e princípios SOLID.

## Entidade Produto

| Campo               | Tipo    | Regras                          |
| ------------------- | ------- | ------------------------------- |
| `name`              | string  | obrigatório, único              |
| `description`       | string  | opcional                        |
| `price`             | decimal | obrigatório, positivo (`> 0`)   |
| `quantity_in_stock` | inteiro | obrigatório, não negativo (`>= 0`) |

## Stack

- PHP 8.2+ / Laravel 12
- Autenticação web por sessão + API por token (Laravel Sanctum)
- Frontend: Blade, Tailwind CSS v4, starting-point-ui
- Testes: PHPUnit (SQLite em memória)

## Arquitetura

- **Controllers finos** — web (`App\Http\Controllers\Painel\ProductController`) e API
  (`App\Http\Controllers\Api\V1\ProductController`).
- **FormRequests** — validação centralizada (`StoreProductRequest`, `UpdateProductRequest`)
  reutilizada por web e API.
- **ProductService** — regra de negócio (create/update/delete), injetado nos dois canais (DIP).
- **Product::scopeFilter** — montagem de busca e filtros compartilhada entre web e API (DRY).
- **ApiResponse trait** + **ProductResource** — resposta padronizada e serialização da API.

## Como executar

```bash
git clone <repo-url>
cd teste-first-decision

composer install
cp .env.example .env
php artisan key:generate

npm install
npm run build

php artisan migrate --seed
php artisan serve
```

Acesse `http://localhost:8000`.

### Credenciais do seed

- **Email:** `firstdecision@example.com`
- **Senha:** `password123`

O seed cria também 15 produtos de exemplo (`ProductSeeder`).

## Como executar os testes

```bash
php artisan test
# ou
vendor/bin/phpunit
```

Cobertura: Unit (Model, Service, Requests) + Feature (auth web, CRUD web, auth API, CRUD API).

## API RESTful (v1)

Base: `/api/v1`. Todas as respostas seguem o envelope:

```json
{ "data": ..., "message": "...", "errors": null }
```

### Autenticação (Bearer token)

```bash
curl -X POST http://localhost:8000/api/v1/login \
  -H "Accept: application/json" \
  -d "email=firstdecision@example.com&password=password123"
```

Resposta:

```json
{
  "data": { "token": "1|xxxxx", "token_type": "Bearer" },
  "message": "Autenticado com sucesso.",
  "errors": null
}
```

Use o token nas demais chamadas: `Authorization: Bearer <token>`.

### Endpoints

| Método | Rota                     | Descrição                              |
| ------ | ------------------------ | -------------------------------------- |
| POST   | `/api/v1/login`          | Autentica e emite token                |
| POST   | `/api/v1/logout`         | Revoga o token atual                   |
| GET    | `/api/v1/products`       | Lista paginada (busca + filtros)       |
| POST   | `/api/v1/products`       | Cria produto                           |
| GET    | `/api/v1/products/{id}`  | Exibe produto                          |
| PUT    | `/api/v1/products/{id}`  | Atualiza produto                       |
| DELETE | `/api/v1/products/{id}`  | Remove produto                         |

Filtros de listagem (query params, web e API): `search`, `price_min`, `price_max`,
`stock_min`, `stock_max`, `per_page`.

Exemplo de listagem:

```json
{
  "data": {
    "items": [ { "id": 1, "name": "...", "price": "10.00", "quantity_in_stock": 5 } ],
    "meta": { "current_page": 1, "last_page": 1, "per_page": 15, "total": 1 }
  },
  "message": "Produtos listados com sucesso.",
  "errors": null
}
```

Erro de validação (`422`):

```json
{
  "data": null,
  "message": "Os dados informados são inválidos.",
  "errors": { "name": ["The name field is required."] }
}
```

## Docker

> Pendente — ambiente Docker (app Laravel + banco) será adicionado na sequência.
