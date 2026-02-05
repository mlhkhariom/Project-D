# MLHK Infotech - E-Commerce Platform

A robust, single-tenant E-commerce solution built with **Laravel 12**, **Livewire**, and **Tailwind CSS**. Designed for client-hosted environments with a powerful Super Admin backend for maintenance and theming.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)

## 🌟 Key Features

### 🔐 Role-Based Architecture
The platform is strictly divided into three distinct panels based on user roles:

1.  **Super Admin (`/superadmin`)**:
    *   **Access:** Only for MLHK Infotech / Platform Owners.
    *   **Features:**
        *   System Health Monitoring (Database, Cache, Versioning).
        *   **Theme Manager:** Instantly switch the public website's design between **20+ unique themes**.
        *   Maintenance tools (Clear cache, etc.).

2.  **Store Admin (`/admin`)**:
    *   **Access:** The Client / Store Owner.
    *   **Features:**
        *   Dashboard with Sales & Order analytics.
        *   Product Management (CRUD).
        *   Order Processing (Placeholder).

3.  **Customer / Public Store**:
    *   **Access:** General public.
    *   **Features:**
        *   **Dynamic Theming:** The entire look and feel adapts to the Super Admin's selection.
        *   Home Page (Hero, Featured Products).
        *   Shop Page (Grid, Filters).
        *   Shopping Cart.
        *   User Dashboard (Profile, Order History).
        *   Seamless Login/Register.

---

## 🎨 Dynamic Theme Engine

This project features a custom **Procedural Theme Engine** (`App\Services\ThemeService`).
Instead of managing 20 static folders, the engine generates unique design systems on the fly by combining:
*   **Color Palettes:** Nature, Ocean, Sunset, Cyber, Luxury, etc.
*   **Modes:** Light & Dark variants.
*   **Typography:** Figtree, Inter, Roboto, etc.
*   **Layouts:** Standard vs. Boxed.

**To switch themes:** Log in as Super Admin -> Go to **Themes** -> Click **Activate** on any preset.

---

## 🚀 Installation & Setup

### Prerequisites
*   PHP 8.2 or higher
*   Composer
*   Node.js & NPM
*   Database (MySQL or SQLite)

### Steps

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd <project-folder>
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Configure your database settings in `.env`.*

4.  **Database & Seeding**
    Run the migrations and seed the default admin accounts:
    ```bash
    php artisan migrate --seed
    ```

5.  **Build Frontend Assets**
    ```bash
    npm run build
    ```

6.  **Run the Server**
    ```bash
    php artisan serve
    ```

---

## 👤 Default Credentials

The `DatabaseSeeder` sets up the following accounts for testing:

| Role | Email | Password | Access |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `super@mlhk.com` | `password` | `/superadmin/dashboard` |
| **Store Admin** | `client@store.com` | `password` | `/admin/dashboard` |
| **Customer** | `customer@gmail.com` | `password` | `/dashboard` |

---

## 📂 Project Structure

*   `app/Services/ThemeService.php`: Core logic for generating and managing themes.
*   `app/Http/Middleware/CheckRole.php`: Protects routes based on user roles.
*   `resources/views/layouts/theme.blade.php`: The master layout for the public frontend (adapts to active theme).
*   `resources/views/livewire/super-admin`: Super Admin components.
*   `resources/views/livewire/admin`: Store Admin components.
*   `resources/views/livewire/public`: Public store components.

---

## 🛠️ Tech Stack

*   **Framework:** Laravel 12 (Dev)
*   **Frontend:** Blade + Livewire + Volt
*   **Styling:** Tailwind CSS
*   **Auth:** Laravel Breeze
*   **DB:** SQLite (Default) / MySQL (Production)
