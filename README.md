<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License">
  </a>
</p>

---

# 🛍️ Ecommerce Laravel

Proyecto base de **Ecommerce** desarrollado con [Laravel 12](https://laravel.com) y [Jetstream](https://jetstream.laravel.com). Este sistema incluye autenticación completa, configuración inicial de frontend con Livewire o Inertia, y está listo para ser expandido con funciones como catálogo de productos, carrito de compras, métodos de pago y panel administrativo.

---

## 🚀 Tecnologías utilizadas

- **Laravel 12**
- **Jetstream + Livewire**
- **Tailwind CSS**
- **Vite**
- **PHP 8.2+**
- **MySQL o SQLite**
- **Composer / NPM**

---

## 📦 Instalación

```bash
git clone https://github.com/erikstiven/ecommerce.git
cd ecommerce
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
