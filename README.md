# pyrocms-cheatsheet
Pyro CMS 3 - CheatSheet

## Seeding
* **Create Seed** `php artisan make:seeder GridSeeder`
* **Run Seed** `php artisan db:seed --class=GridSeeder`

## Module
* **Create Module** `php artisan make:addon my_project.module.library`
* **Create Stream** `php artisan make:stream books my_project.module.library`
* **Install Module** `php artisan module:install my_project.module.library`
* **UnInstall Module** `php artisan module:uninstall my_project.module.library`
* **ReInstall Module** `php artisan module:reinstall my_project.module.library`
