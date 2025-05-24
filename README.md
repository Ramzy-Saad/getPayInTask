# Laravel Social Media Scheduler

This is a Laravel project that provides both:
- A RESTful API (secured using **Laravel Sanctum**)
- A frontend UI using **Blade templates**

It allows users to:
- Register/Login
- Create and manage social media posts
- Schedule posts to multiple platforms (e.g., Twitter, Instagram, LinkedIn)
- View scheduled posts on a calendar using FullCalendar
- Apply daily post limits (max 10 scheduled posts/day)
- View and filter posts by status (published, scheduled, draft)

---

## 🚀 Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM (for compiling frontend assets)
- MySQL or other supported DB
- Laravel CLI

---

## ⚙️ Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
2. **install PHP dependencies:**
   composer install
3. **Copy .env and generate key:**
   cp .env.example .env
    php artisan key:generate
4. **CConfigure your .env with database and other settings.**
5. **Run migrations and seeders:**
    php artisan migrate --seed

6. **Install and compile frontend assets:**
    npm install
    npm run dev
7. **Start Laravel server:**
    php artisan serve
8. **Access the app:**
    Blade UI: http://localhost:8000
    API Base: http://localhost:8000/api


** Authentication **
    API uses Laravel Sanctum.
    Use POST /api/register and POST /api/login for user registration and login.
    Include Bearer token in API requests for authentication.

** Postman Collection **
    Located in postManCollection/
    Import SocialMediaScheduler.postman_collection.json into Postman.
    Set base URL: http://localhost:8000/api
