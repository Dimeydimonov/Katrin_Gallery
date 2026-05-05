Katrin Gallery - Art Portfolio Management System

Overview
Katrin Gallery is a professional art gallery platform designed for artist Kateryna Pohrebenna from Odesa. Built with Laravel 12 and modern web technologies, it provides a comprehensive solution for showcasing and managing art portfolios with social engagement features.

Features 
Art Gallery: Organized artwork display with category management 
Social Engagement: Like and comment system for artworks 
Admin Panel: Full content management capabilities 
Multi-language: Ukrainian and English language support 
Responsive Design: Mobile-optimized viewing experience 
Image Management: Advanced image upload and processing 
REST API: Sanctum-powered API for external integrations 
Search & Filter: Advanced artwork search and filtering

 Tech Stack
Backend: Laravel 12, PHP 8.2
Database: MySQL
Authentication: Laravel Sanctum
Containerization: Docker & Docker Compose
Storage: Laravel Storage with public disk
Localization: Built-in multi-language support

 Architecture Highlights 
 Service Layer Pattern: Business logic separated from controllers 
 Interface-based Design: Services implement contracts/interfaces 
 Error Handling: Comprehensive exception management 
 Clean Controllers: Thin controllers with dependency injection 
 Repository Pattern: Data access abstraction (where applicable)

 Installation

 Prerequisites
Docker & Docker Compose
Git

 Setup Instructions
bash
 Clone the repository
git clone [repository-url]
cd Katrin_Gallery

 Start Docker containers
docker compose up -d

 Enter the PHP container
docker compose exec app bash

 Install dependencies
composer install
npm install

 Configure environment
cp .env.example .env
php artisan key:generate

 Setup database
php artisan migrate
php artisan db:seed

 Create storage symlink
php artisan storage:link

 Build frontend assets
npm run build


 Usage

 Access Points
- Main Site: http://localhost
- Admin Panel: http://localhost/admin
  - Default credentials: `admin@example.com` / `password`

 API Documentation
The API is secured with Laravel Sanctum. Available endpoints:
- `GET /api/artworks` - List all artworks
- `GET /api/artworks/{id}` - Get artwork details
- `GET /api/categories` - List categories
- `POST /api/artworks/{id}/like` - Like an artwork
- `POST /api/artworks/{id}/comment` - Add comment

 Development

 Commands
bash
 Development server with hot reload
npm run dev

 Run tests
php artisan test

 Code formatting
php artisan pint

 Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

 Generate API documentation
php artisan l5-swagger:generate


 Docker Services 
 app: PHP-FPM application container
nginx: Web server
mysql: Database server
redis: Cache and session storage (if configured)

 Project Structure

app/
─ Http/
  ── Controllers/       Thin controllers
  ── Middleware/         Custom middleware
─ Services/               Business logic layer
─ Models/                 Eloquent models
─ Contracts/              Service interfaces
─ Exceptions/             Custom exceptions
resources/
─ views/                  Blade templates
─ lang/                   Language files (ua/en)
─ js/                     Frontend JavaScript
routes/
─ web.php                 Web routes
─ api.php                 API routes
database/─ migrations/             Database migrations─ seeders/                Database seeders


 Testing
bash
 Run all tests
php artisan test

 Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

 Run with coverage
php artisan test --coverage


 Security
CSRF protection enabled
XSS prevention through blade escaping
SQL injection prevention via Eloquent ORM
API authentication with Sanctum tokens
Rate limiting on API endpoints

 Contributing
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

 License
This project is proprietary software. All rights reserved.

 Support
For support and inquiries, please contact the development team or create an issue in the repository.

 Credits
Developed for artist Kateryna Pohrebenna, Odesa, Ukraine.