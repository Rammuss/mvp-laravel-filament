# PLAN MVP - Laravel + Filament + PostgreSQL

## 1) Objetivo del MVP
- Landing publica.
- Login para 1 admin.
- Panel autogestionable para editar contenido de la landing.

## 2) Stack definido
- Backend/App: Laravel 12
- Panel admin: Filament 3
- Base de datos: PostgreSQL (Coolify resource: `mvp-postgres`)
- Frontend landing: Blade + Tailwind
- Deploy: Coolify desde GitHub

## 3) Estructura inicial del proyecto
```text
mvp-laravel-filament/
  app/
  bootstrap/
  config/
  database/
    migrations/
    seeders/
  public/
  resources/
    views/
      landing/
      admin/
  routes/
    web.php
  storage/
  tests/
  .env.example
  composer.json
  README.md
```

## 4) Modelo de datos inicial (simple)

### Tabla `users` (Laravel auth)
- id
- name
- email (unique)
- password
- is_admin (boolean, default false)
- timestamps

### Tabla `pages`
- id
- slug (unique)  // ej: `home`
- title
- timestamps

### Tabla `sections`
- id
- page_id (fk pages)
- section_key  // ej: `hero`, `about`, `services`, `contact`
- content_json (jsonb)
- sort_order (int)
- is_visible (bool)
- timestamps

## 5) Reglas de acceso
- Registro publico: desactivado.
- Solo 1 usuario admin inicial (seeder).
- Solo `is_admin = true` entra a Filament.

## 6) Flujo de trabajo
1. Desarrollar localmente.
2. Commit y push a GitHub (`main`).
3. Coolify hace deploy desde repo.
4. Ejecutar migraciones en deploy.

## 7) Variables de entorno de produccion (minimas)
```env
APP_NAME="MVP Marcos"
APP_ENV=production
APP_DEBUG=false
APP_KEY=
APP_URL=

DB_CONNECTION=pgsql
DB_HOST=mvp-postgres
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 8) Orden de implementacion
1. Crear Laravel base.
2. Configurar auth sin registro publico.
3. Instalar Filament y proteger panel para admin.
4. Crear migraciones `pages` y `sections`.
5. Crear CRUD de secciones en Filament.
6. Renderizar landing dinamica desde DB.
7. Configurar deploy en Coolify.
