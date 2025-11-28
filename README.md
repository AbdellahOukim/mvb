# MVB Framework

> Modern View-Backed PHP framework engineered by **2R Technology in 2025**, combining a lightweight core with expressive developer ergonomics.

## English

### Overview

- MVB delivers an MVC-style workflow with PSR-4 autoloading, BladeOne templating, PDO-backed models, middleware-aware routing, and localization helpers.
- The framework favors explicit PHP classes over magic, keeping the core readable inside `core/`, userland code in `app/`, and presentation assets in `src/`.

### Highlights

- **Routing & Middleware** – `Core\Route` maps URI prefixes to controllers and can wrap route groups in stackable middlewares before resolving controller methods.
- **Controllers & Responses** – `Core\BaseController` surfaces helpers (`view`, `json`, `redirect`) while `Core\RedirectResponse` keeps flash messaging and request state.
- **Active Record Models** – `Core\BaseModel` exposes fluent `find`, `where`, `join`, and `with` chaining backed by PDO with safe parameter binding and eager loading.
- **Auth & Policies** – `Core\Auth` offers session-backed login workflows that pair with policy classes evaluated through `Core\Policy::check`.
- **Validation & Files** – `Core\Validate` handles human-readable rule strings; `Core\File` centralizes uploads, storage, and deletion.
- **Queues & Workers** – `Core\Queue` persists delayed jobs into `queue_jobs`, consumed via `public/cli/worker.php` for background execution with retries.
- **Localization** – `core/helpers.php` ships `__t()` lookup helpers and `setLang()` session utilities, reading resources in `src/lang/`.
- **CLI Scaffolding** – The `mvb` binary scaffolds models, controllers, policies, seeders, as well as cache maintenance.

### Project Layout (excerpt)

- `app/controllers` – HTTP controllers inheriting from `Core\BaseController`.
- `app/models` – Domain models extending `Core\BaseModel`.
- `app/middlewares` – Request middleware (`AuthMiddleware` sample).
- `core/` – Routing, ORM, validation, queue, files, view abstraction, and helpers.
- `routes/web.php` – Route map executed at boot.
- `src/views` – Blade templates rendered by `Core\View`.
- `public/index.php` – Front controller loading Dotenv, helpers, and dispatching routes.
- `public/cli/worker.php` – Queue worker loop for asynchronous jobs.

### Requirements

- PHP 8.1+
- Composer
- MySQL-compatible database (PDO MySQL enabled)
- Optional: Supervisor/process manager for the queue worker

### Installation

1. Clone the repository and install dependencies:
   ```bash
   git clone <repo-url> mvb-framework
   cd mvb-framework
   composer install
   ```
2. Create an `.env` file supplying `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_PORT`.
3. Point your web server (or `php -S localhost:8000 -t public`) to the `public/` directory.
4. Configure your database schema (at minimum `users` and `queue_jobs` tables).
5. Update `routes/web.php` with new controllers and call `Route::make()` entries.

### Routing & Controllers

Route registration uses URI prefixes and automatically delegates to methods that match the remaining path segments:

```5:9:routes/web.php
use Core\Route;
use App\controllers\HomeController;

Route::make('/', HomeController::class);
```

Controllers extend `App\controllers\Controller`, inheriting the `view()` helper to render Blade templates:

```6:14:app/controllers/HomeController.php
class HomeController extends Controller
{
    public function index()
    {
        return $this->view("home");
    }
}
```

### Working with Models

- Extend `App\models\Model` and set the `$table` property to map to your database table.
- Chain `find()->where()->with()` to build queries; call `get()` or `first()` to execute.
- Use `insert`, `insertMany`, `update`, `updateWhere`, `delete`, or `findOrCreate` for mutations.

### Authentication & Authorization

- Call `Core\Auth::attempt(['email' => ..., 'password' => ...])` to log in users stored in the `users` table.
- Store policies in `App\policies` and evaluate capabilities with `can(Policy::class, 'method', $resource)`.

### Validation & Localization

- Validate request payloads via `Core\Validate::make($data, ['email' => 'required|email'])`.
- Translate UI strings with `__t('key')`, populate string dictionaries in `src/lang/fr.php`, `src/lang/ar.php`, etc., and persist locale using `setLang('fr')`.

### CLI Tooling

- `php mvb create:model User --table=users`
- `php mvb create:controller Dashboard`
- `php mvb create:policy Project`
- `php mvb create:seeder UserSeeder`
- `php mvb run:seeder UserSeeder`
- `php mvb delete:cache`

The CLI auto-creates namespaced PHP files under `app/` directories, announcing writes in the terminal.

### Queues & Background Jobs

1. Push jobs via `Core\Queue::push(JobClass::class, ['payload' => 'value'], $delaySeconds)`.
2. Implement `handle(array $data)` on the job class.
3. Run the worker: `php public/cli/worker.php`. The worker:
   - polls `queue_jobs`,
   - instantiates the stored job class,
   - deletes successful jobs or increments the `attempts` column on failure.
4. Use a process manager (Supervisor/systemd) to keep the worker alive in production.

### Development Workflow

- Serve locally: `php -S 127.0.0.1:8000 -t public`.
- Tail logs / watch `storage/` for cache output from Blade.
- Clear compiled views via `php mvb delete:cache`.

### Testing Ideas

- Cover routing expectations with feature tests using `phpunit` or Pest (not bundled yet).
- Stub the database connection for unit tests with an in-memory SQLite DSN and override env variables.

### Deployment Notes

- Point your document root at `public/`.
- Ensure `.env` and `storage/` directories are writable but not web-accessible.
- Run `composer install --no-dev --optimize-autoloader` in CI.
- Start the queue worker alongside the HTTP server if background jobs are used.

### License

- MIT License, see `composer.json`.

---

## Français

### Aperçu

- MVB est un framework PHP MVC léger conçu par **2R Technology en 2025**, combinant routes explicites, BladeOne, ORM actif, validation intégrée, politiques d’accès et outils CLI.
- Le noyau se situe dans `core/`, tandis que vos classes métier résident dans `app/` et vos vues dans `src/`.

### Démarrage rapide

1. `composer install`
2. Créez `.env` avec vos variables MySQL (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_PORT`).
3. Lancez `php -S localhost:8000 -t public` ou configurez votre serveur web vers `public/`.
4. Ajoutez vos routes dans `routes/web.php` et créez vos contrôleurs avec `php mvb create:controller Nom`.

### Fonctionnalités majeures

- Routage orienté préfixe avec middlewares (`App\middlewares\AuthMiddleware`).
- ORM `Core\BaseModel` incluant `find`, `where`, `with`, `insertMany`, `findOrCreate`.
- Authentification session avec `Core\Auth` et autorisations via `Core\Policy`.
- Validation déclarative (`required`, `email`, `min`, `max`, etc.) grâce à `Core\Validate`.
- Internationalisation via `__t()` et fichiers `src/lang/fr.php`, `src/lang/ar.php`.
- File d’attente SQL (`Core\Queue`) et worker CLI (`public/cli/worker.php`).
- Générateur CLI `mvb` (modèles, contrôleurs, policies, seeders, nettoyage du cache).

### Commandes utiles

- `php mvb create:model Produit --table=products`
- `php mvb create:policy OrderPolicy`
- `php mvb run:seeder UserSeeder`
- `php mvb delete:cache`
- `php public/cli/worker.php` (lancer le worker)

### Bonnes pratiques

- Gardez vos clés secrètes et accès DB uniquement dans `.env`.
- Utilisez `setLang('fr')` / `setLang('ar')` pour fixer la langue de session.
- Surveillez la table `queue_jobs` et ajoutez des index sur `available_at` pour de meilleures performances.
- Déployez avec `composer install --no-dev` et un serveur pointé vers `public/`.

---

## العربية

### نظرة عامة

- إطار عمل **MVB** هو حل PHP خفيف يعتمد نمط MVC، طوّرته **2R Technology في عام 2025**، ويوفر توجيهًا مرنًا، ونماذج نشطة، وقوالب BladeOne، ومحرك ترجمة متعدد اللغات.

### طريقة التثبيت

1. استنسخ المستودع وثبّت الاعتمادات: `composer install`.
2. أنشئ ملف `.env` لإعداد معلومات قاعدة البيانات (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_PORT`).
3. شغّل الخادم المحلي: `php -S 127.0.0.1:8000 -t public`.
4. أضف المسارات داخل `routes/web.php`، وابنِ المتحكمات عبر الأمر `php mvb create:controller Blog`.

### ما يميز الإطار

- **التوجيه والميدل وير**: صنف `Core\Route` يربط المسارات بالمتحكمات ويدعم ميدل وير مثل `AuthMiddleware`.
- **النماذج وقاعدة البيانات**: `Core\BaseModel` يسهّل الاستعلامات (`find`, `where`, `join`, `with`) والتعامل مع الإدخال والتحديث والحذف عبر PDO.
- **التحقق والملفات**: استخدم `Core\Validate` لقواعد مثل `required|min:3` وتعامل مع الرفع عبر `Core\File`.
- **التوثيق والتصاريح**: قم بتسجيل الدخول باستخدام `Core\Auth::attempt` وطبّق سياسات الصلاحيات بواسطة `Core\Policy`.
- **نظام الطوابير**: أدخل مهام الخلفية بـ `Core\Queue::push` وشغّل العامل الموجود في `public/cli/worker.php`.
- **التعريب**: وفر ترجماتك في `src/lang/ar.php` واستدعها من القوالب باستخدام الدالة `__t()`.

### أوامر CLI مفيدة

- `php mvb create:model User`
- `php mvb create:policy Invoice`
- `php mvb run:seeder DemoSeeder`
- `php mvb delete:cache`
- `php public/cli/worker.php` لتشغيل عامل الطابور

### ملاحظات الإنتاج

- اجعل جذر الخادم يشير إلى `public/`.
- احمِ ملف `.env` وامنح الصلاحيات للكتابة إلى `storage/`.
- استخدم مدير عمليات لمراقبة عامل الطابور وإعادة تشغيله تلقائيًا عند الإخفاق.

---

Happy building with MVB!
