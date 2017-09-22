# Installing pyrocms 3.4 from scratch

## Run composer
`composer create-project pyrocms/pyrocms yourproject.dev`

## Setup your .env file
```
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:98P3BHq99h+luw2jddRFRldiIDvFVQDkP2u793Ud01w=
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=workbench
DB_USERNAME=root
DB_PASSWORD=""
APPLICATION_NAME=Default
APPLICATION_REFERENCE=default
APPLICATION_DOMAIN=localhost
ADMIN_EMAIL=william@pixney.com
ADMIN_USERNAME=admin
ADMIN_PASSWORD=admin
LAZY_TRANSLATIONS=true
DB_CACHE=true
LOCALE=en
TIMEZONE=UTC
```

## Generate a new key
`php artisan key:generate`

## Run the installer
`php artisan install --ready`

## Remove the installer module
Once everything is installed, we don't want the installer requirements left in our composer.json file. Remove `"anomaly/installer-module": "~2.3.0"`. I 3.4, this is in dev requirements. Meaning on production, you could run `composer install --no-dev` to not include it as well. To be safe, let's remove that line and when done run `composer update`

## Set permissions
`chmod -R 755 public/app`  
`chmod -R 755 bootstrap/cache`  
`chmod -R 755 storage`

## You are now ready
You are now completely done with the installation process. Start developing!

## Up next
In the following post ill go through how i set up my environments when it comes to compiling sass, javascript and such things.
