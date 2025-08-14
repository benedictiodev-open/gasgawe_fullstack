# Gas Gawe Fullstack

## Documentation: Run the Project

This guide explains how to set up and run the Gas Gawe Fullstack project locally, including environment requirements.

---

### Environment Requirements

- **PHP**: ^8.2
- **Composer**: Latest version
- **Node.js**: v18 or newer recommended
- **npm**: Latest version
- **Database**: MySQL or SQLite (configure in `.env`)
- **Git**: For cloning the repository
- **Firebase**: Service account credentials (`credentials.json`)

---

### Steps to Run the Project

### 1. Clone the repository

```sh
git clone https://github.com/your-username/gasgawe_fullstack.git
cd gasgawe_fullstack
```

### 2. Install dependencies

```sh
composer install
npm install
```

### 3. Copy environment file

```sh
cp .env.example .env
```

Edit `.env` as needed for your local setup.

### 4. Generate application key

```sh
php artisan key:generate
```

### 5. Run migrations and seeders

```sh
php artisan migrate --seed
```

### 6. Build frontend assets

```sh
npm run build
```

### 7. Start the development server

```sh
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

### 8. Build Swagger Open-API

```sh
php artisan l5-swagger:generate
```

Visit [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) in your browser.

---

### Configure Firebase Authentication

### 1. Download your Firebase service account credentials from the [Firebase Console](https://console.firebase.google.com/) and save it as `firebase_credentials.json` in the project root.

### 2. Move file `firebase_credentials.json` to folder storage

```sh
PROJECT/storage/firebase_credentials.json
```

### 3. The project will use this file for Firebase authentication features.

---

## Additional Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Contributing Guide](https://laravel.com/docs/contributions)
