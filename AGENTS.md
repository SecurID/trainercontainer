# Repository Guidelines

## Project Structure & Module Organization
- `app/` holds Laravel domain logic (models, Livewire actions, policies); keep new PHP classes under relevant domain subfolders.
- `routes/web.php` and `routes/api.php` define trainer- and API-facing endpoints; pair route changes with matching Livewire or controller updates.
- `resources/views` contains Blade layouts and Livewire views; `resources/js` stores the Vue-based SoccerDraw tool and shared JS.
- `database/migrations` and `database/seeders` manage schema and fixtures; update `database/factories` when persisting new models.
- `tests/Feature` and `tests/Unit` cover HTTP flows and pure logic respectively; mirror new features with dedicated specs.

## Build, Test, and Development Commands
- `composer install` / `npm install` install PHP and Node dependencies.
- `php artisan migrate --seed` brings the SQLite dev database in sync with baseline seed data.
- `php artisan key:generate` refreshes the application key after cloning.
- `./vendor/bin/pest` runs the full PHP test suite; pass `--group` to target tagged tests.
- `npm run dev` launches the Vite dev server for Tailwind and Vue assets; `npm run build` produces production bundles.

## Coding Style & Naming Conventions
- Follow PSR-12 with 4-space indentation for PHP; keep Livewire component classes in PascalCase and blade templates in kebab-case (e.g., `player-practice-rating.blade.php`).
- Vue single-file components live under `resources/js/components` in PascalCase; export default names must match filenames.
- Favor Tailwind utility classes; custom styles belong in `resources/css/app.css`.
- Run Laravel Pint (`./vendor/bin/pint`) before submitting to ensure consistent formatting.

## Testing Guidelines
- Pest is the default framework; describe scenarios with `it()` blocks and snake_case test function names.
- Co-locate factories in `database/factories` and refresh the database via Pest's `RefreshDatabase` trait when tests mutate state.
- Add end-to-end checks for new Livewire flows in `tests/Feature`; isolate pure services under `tests/Unit`.

## Commit & Pull Request Guidelines
- Use conventional prefixes observed in history (`feat:`, `fix:`, `refactor:`) followed by imperative summaries.
- Reference issue IDs or Trello cards in the body when available, and list any migrations or breaking changes.
- PRs should outline context, screenshots for UI changes, seeded data required, and the test commands executed (`./vendor/bin/pest`, `npm run build`).

## Environment & Configuration Tips
- Copy `.env.example` to `.env`, set database credentials, and point to `database/database.sqlite` for local builds.
- Storage symlinks (`php artisan storage:link`) are required before serving uploaded media.
- Avoid committing `.env`, `storage/`, or generated PDFs; rely on Git LFS only when explicitly requested.
