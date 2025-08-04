# Translations API

A Laravel-based API project using standard controller and resource structure.

---

## 🚀 Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
```

2. **Install dependencies**
```bash
composer install
```

3. **Copy `.env` and set config**
```bash
cp .env.example .env
```
- Set your database credentials.
- Set `APP_KEY`, `APP_URL`, etc.

4. **Generate application key**
```bash
php artisan key:generate
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Run the server**
```bash
php artisan serve
```

---

## 🔐 Sanctum Authentication

Login via:

```
POST /api/auth/login
```

Payload:
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

Response:
```json
{
  "token": "your-api-token"
}
```

Use the token in `Authorization: Bearer <token>` header.

---

## 📁 API Structure

- `app/Http/Controllers/Api/`
  - `AuthController.php`
  - `CategoryController.php`
  - `LanguageController.php`

- Uses standard **API Resource** pattern.

---

## 📚 Postman / API Collection

You can import the full API collection via:

[📥 Download API Collection (Postman)](./postman_collection.json)

*(Add your collection export as `postman_collection.json` in the root folder.)*

---

## ✅ Run Tests

```bash
php artisan test
```

Make sure test DB is configured in `.env.testing`.

---

## 🧑‍💻 Author

Made with Laravel by [Your Name]
