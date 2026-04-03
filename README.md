# Laravel REST API — Task Submission

A Laravel project implementing a Product REST API and an external API consumer.

---

## 📋 Tasks Covered

| Task | Description |
|------|-------------|
| Task 1 | Build a Simple REST API for Products |
| Task 2 | Consume External API (JSONPlaceholder) |
| Task 5 | Git & Documentation |

---

## ⚙️ Requirements

- PHP >= 8.1
- Composer
- MySQL / PostgreSQL / SQLite
- Laravel v12.12.2

---

## 🚀 Setup & Installation

### 1. Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
cd YOUR_REPO_NAME
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Configure Database

Open `.env` and update these values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_tasks
DB_USERNAME=root
DB_PASSWORD=your_password
```

> 💡 For quick local testing, you can use SQLite:
> ```env
> DB_CONNECTION=sqlite
> ```
> Then create the file: `touch database/database.sqlite`

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Start the Development Server

```bash
php artisan serve
```

The app will be running at: `http://127.0.0.1:8000`

---

## 📦 Task 1 — Product REST API

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | List all products (paginated) |
| POST | `/api/products` | Create a new product |
| DELETE | `/api/products/{id}` | Delete a product by ID |

---

### GET `/api/products`

Lists all products. Supports pagination via `?per_page=N` (default: 10).

**Request:**
```
GET /api/products
GET /api/products?per_page=5
```

**Response:**
```json
{
    "success": true,
    "message": "Products retrieved successfully.",
    "data": [
        {
            "id": 1,
            "name": "Laptop",
            "price": "999.99",
            "description": "A powerful laptop.",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 10,
        "total": 1
    }
}
```

---

### POST `/api/products`

Creates a new product.

**Request Body (JSON):**
```json
{
    "name": "Laptop",
    "price": 999.99,
    "description": "A powerful laptop."
}
```

**Validation Rules:**
| Field | Rules |
|-------|-------|
| name | required, string, max:255 |
| price | required, numeric, min:0 |
| description | optional, string, max:1000 |

**Success Response (201):**
```json
{
    "success": true,
    "message": "Product created successfully.",
    "data": {
        "id": 1,
        "name": "Laptop",
        "price": "999.99",
        "description": "A powerful laptop.",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

**Validation Error Response (422):**
```json
{
    "success": false,
    "message": "Validation failed.",
    "errors": {
        "price": ["Product price is required."]
    }
}
```

---

### DELETE `/api/products/{id}`

Deletes a product by its ID.

**Request:**
```
DELETE /api/products/1
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Product 'Laptop' deleted successfully."
}
```

**Not Found Response (404):**
```json
{
    "success": false,
    "message": "Product with ID 999 not found."
}
```

---

## 🌐 Task 2 — External API Consumer

Fetches posts from [JSONPlaceholder](https://jsonplaceholder.typicode.com/posts) and returns the first 10, showing only `title` and `body`.

### Endpoint

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/posts` | Get first 10 posts |
| GET | `/api/posts?search=keyword` | Filter posts by title |

---

### GET `/api/posts`

**Request:**
```
GET /api/posts
```

**Response:**
```json
{
    "success": true,
    "message": "Posts retrieved successfully.",
    "search": null,
    "count": 10,
    "data": [
        {
            "title": "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            "body": "quia et suscipit\nsuscipit recusandae consequuntur..."
        }
    ]
}
```

---

### GET `/api/posts?search=keyword` *(Bonus)*

Filters posts by title keyword (case-insensitive).

**Request:**
```
GET /api/posts?search=dolorem
```

**Response:**
```json
{
    "success": true,
    "message": "Posts retrieved successfully.",
    "search": "dolorem",
    "count": 3,
    "data": [
        {
            "title": "dolorem eum magni eos aperiam quia",
            "body": "ut aspernatur corporis harum nihil..."
        }
    ]
}
```

---

## 🧪 Testing with cURL-> Yoy may also test by using Postman 

```bash
# List products
curl http://127.0.0.1:8000/api/products

# Create a product
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{"name":"Phone","price":499.99,"description":"Smartphone"}'

# Delete a product
curl -X DELETE http://127.0.0.1:8000/api/products/1

# Fetch posts
curl http://127.0.0.1:8000/api/posts

# Search posts by title
curl "http://127.0.0.1:8000/api/posts?search=dolorem"
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── ProductController.php   ← Task 1
│   │       └── PostController.php      ← Task 2
│   └── Requests/
│       └── StoreProductRequest.php     ← Validation
├── Models/
│   └── Product.php
database/
└── migrations/
    └── 2026_04_03_020250_create_products_table.php
routes/
└── api.php
```

---

## 👤 Author

Submitted as part of Laravel/PHP developer job assessment.