# AGENTS.md

## Project

Laravel 10 forest ranger management app ("Laskar Alas"). PHP 8.1+, Vite, Blade templates.

## Dev Commands

```bash
php artisan serve          # Start dev server
npm run dev                # Vite dev server (HMR)
npm run build              # Production Vite build
php artisan migrate        # Run migrations
php artisan db:seed        # Seed users (super/admin/user roles)
php artisan test           # Run PHPUnit (Feature + Unit suites)
vendor/bin/pint            # Laravel Pint code style fixer (dev dep, no config file)
```

## Database

MySQL, database name `laskar`. See `.env.example` for defaults.
Migrations in `database/migrations/`. Run `php artisan migrate:fresh --seed` to reset.

## Architecture

### Roles & Access Control

Three roles stored as enum in `users.role`: `super`, `admin`, `user`.
Custom `RoleMiddleware` (`app/Http/Middleware/RoleMiddleware.php`) registered as `role` alias in `app/Http/Kernel.php:67`.

Route groups in `routes/web.php`:
- `/super/*` — `role:super` — Full admin: manage pegawai, BKPH, RPH, jadwal, laporan
- `/admin/*` — `role:admin` — BKPH-scoped: manage BKPH, RPH, jadwal, validate laporan, PDF export
- `/user/*` — `role:user` — Staff: submit laporan, view jadwal

Root `/` redirects to `/login`.

BKPH areas are hardcoded as named routes (`bkphrogojampi`, `bkphlicin`, `bkphglenmore`, `bkphsempu`, `bkphkalibaru`). The `{daerah}` wildcard routes handle CRUD for each area.

### Domain Model

```
User (role enum: super/admin/user)
 └─ Pegawai (1:1 via user_id)
     ├─ BKPH (1:N via pegawai_id)
     │   └─ RPH (1:N via bkph_id)
     │       └─ Laporan (via rph.pegawai_id)
     ├─ Jadwal (1:N via pegawai_id)
     └─ Laporan (1:N via pegawai_id)
```

Key models: `app/Models/{User,Pegawai,BKPH,RPH,Laporan,Jadwal}.php`
Foreign keys use `onDelete('cascade')` throughout.

### Controllers

Organized by role in `app/Http/Controllers/{Super,Admin,User}/`:
- `Super/BKPHController` — BKPH CRUD, scoped by `daerah` (area name) parameter
- `Super/PegawaiController`, `Super/RPHController`, `Super/JadwalController`, `Super/LaporanController`
- `Admin/BKPHController` — Admin-scoped BKPH management (separate from Super)
- `Admin/RPHController` — Admin-scoped RPH management (separate from Super)
- `Admin/LaporanController` — validate laporan (status: `proses` → `divalidasi`), PDF export via DomPDF
- `Admin/JadwalController`, `Admin/DashboardController`
- `User/LaporanController` — submit/edit/delete own laporan
- `User/JadwalController`, `User/DashboardController`

### Views & Layouts

Two layout systems coexist:
- `resources/views/layouts/master.blade.php` — **Primary layout**. Bootstrap-based sidebar + header. Uses `@yield('content')`. Most pages use this.
- `resources/views/layouts/app.blade.php` — Breeze/Tailwind layout. Only used by profile page. Uses `{{ $slot }}`.
- `resources/views/layouts/components/sidebar.blade.php` — Role-based sidebar navigation.

Page views mirror route structure: `resources/views/pages/{super,admin,user}/`.

### Assets

- `public/assets/` — Pre-built CSS/JS (Bootstrap, jQuery, ApexCharts, SimpleBar). Loaded by `master.blade.php`.
- `resources/css/app.css`, `resources/js/app.js` — Vite entrypoints. Loaded by `app.blade.php`.
- Tailwind config scans Blade templates but is only used by the Breeze layout.
- SweetAlert2 loaded via CDN in `master.blade.php`.

### PDF Export

Admin laporan export uses `barryvdh/laravel-dompdf`. PDF view at `resources/views/pages/admin/laporan/pdf.blade.php`. Paper size: A4 landscape.

## Gotchas

- **No `pint.json` or `.php-cs-fixer.php`** — Pint runs with defaults.
- **No CI/CD workflows** — No GitHub Actions, no pre-commit hooks.
- **No custom Blade components beyond Breeze defaults** — `resources/views/components/` are stock Breeze.
- **Seeder hardcodes test users** with password `12341234`. Don't commit real credentials.
- **Laporan status is enum** — only `proses` and `divalidasi` are valid values.
- **BKPH routes use `{daerah}` wildcard** — the parameter is the area name string, not an ID.
- **`pegawais.bkph_id` column exists in model but not in migration** — `Pegawai` model has `belongsTo(BKPH)` but the migration only creates `user_id`, `nip`, `jabatan`, `alamat`. This relation may be unused or broken.
- **Admin has separate controllers from Super** — `Admin/BKPHController` and `Admin/RPHController` are distinct from `Super/BKPHController` and `Super/RPHController`.
- **`.env.example` contains hardcoded Gmail credentials** — Rotate before production use.
- **Tests directory exists but may be empty** — Check `tests/Feature/` and `tests/Unit/` before assuming test coverage.
