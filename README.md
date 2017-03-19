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
* **Publish Addon** `php artisan addon:publish library`

## Publish Commands
* **Publish all addons to the resources/{ref}/addons folder** `php artisan addon:publish`
* **Publish streams configuration to resources/streams** `php artisan streams:publish`
* **Publish posts module only** `php artisan addon:publish anomaly.module.posts`
* **Publish for an app other than the default one** `php artisan addon:publish anomaly.module.posts --app=my_ref`
* **Publish streams config for an app other than your default one** `php artisan streams:publish --app=my_ref`

