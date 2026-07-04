# Miradent - Sistema de Clínica Odontológica

Este proyecto está desarrollado con [Laravel](https://laravel.com/) y requiere de ciertos programas y comandos para funcionar correctamente en cualquier entorno de desarrollo o en producción.

## Requisitos Previos

Antes de instalar el proyecto, asegúrate de tener instalado en tu computadora o servidor:

1. **PHP**: Versión 8.3 o superior.
2. **Composer**: Gestor de dependencias de PHP.
3. **Node.js y npm**: Necesario para compilar los archivos de frontend (JavaScript y CSS).
4. **Base de Datos**: MySQL, MariaDB, PostgreSQL o SQLite (según cómo esté configurado en tu archivo `.env`).

## Pasos para la Instalación

Sigue estos pasos para hacer funcionar la página desde cero, suponiendo que ya descargaste y descomprimiste el proyecto:

### 1. Instalar dependencias de PHP (Backend)
Abre la terminal en la carpeta del proyecto y ejecuta:
```bash
composer install
```
*(Esto descargará nuevamente la carpeta `vendor` con todas las dependencias del backend que fueron borradas para aligerar el proyecto).*

### 2. Configurar el archivo de Entorno
Copia el archivo de ejemplo para crear tu propio archivo de configuración:
```bash
cp .env.example .env
```
Luego, abre el archivo `.env` que se acaba de crear y configura las credenciales de tu base de datos (secciones `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

### 3. Generar la clave de la aplicación
```bash
php artisan key:generate
```

### 4. Instalar dependencias de Node.js (Frontend)
Ejecuta el siguiente comando:
```bash
npm install
```
*(Esto descargará la carpeta `node_modules` con todas las librerías necesarias, como axios, vite, etc., que también fueron borradas para reducir el tamaño del proyecto).*

### 5. Compilar los archivos de diseño (CSS/JS)
```bash
npm run build
```
*(Para entorno de desarrollo, puedes usar `npm run dev`).*

### 6. Ejecutar las migraciones de la Base de Datos
Esto creará las tablas necesarias en la base de datos que configuraste en el paso 2:
```bash
php artisan migrate
```

### 7. Iniciar el servidor local
Finalmente, para ver la página funcionando, levanta el servidor de desarrollo de Laravel:
```bash
php artisan serve
```
La aplicación estará disponible en `http://localhost:8000`.

---
**Nota:** El proyecto incluye un atajo en `composer.json` que automatiza varios de estos pasos. Si tu base de datos ya está configurada, podrías simplemente ejecutar `composer setup`.
