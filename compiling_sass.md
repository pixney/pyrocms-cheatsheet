# Using MIX to compile sass files when developing websites with Pyrocms

## Install node dependencies
`npm install`

## Bootstrap our theme
`php artisan make:addon driverless.theme.driverless` creates your theme in `addons/default/driverless/`

### Remove things we don't need
I always delete everything in `addons/default/driverless/driverless-theme/` except the `lang` and `views` directories. These are the only directories we need for now.

### Install bootsrap
First uninstall the old bootstrap `npm uninstall bootstrap-sass` then install bootstrap 4 :  `npm install bootstrap@4.0.0-beta`

Copy `node_modules/bootstrap/scss/_variables.scss` into `resources/assets/sass/variables.scss`.


Let's change `resources/assets/sass/app.scss` into:


`// Variables`  
`@import "variables";`

`// Bootstrap`  
`@import "node_modules/bootstrap/scss/bootstrap.scss";`


As you will be able to see below, when we compile our css it will be stored as `public/css/app.css`. To make sure our theme use that css file, let's make sure the metadata.twig file located at `addons/default/driverless/driverless-theme/resources/views/partials/metadata.twig` references that css file.


`{{ asset_add("theme.css", "public::css/app.css",["live"]) }}`  
`<style type="text/css">`  
`  {{ asset_inline("theme.css") }}`  
`</style>`  


## Edit webpack.mix.js

During development, you could use these settings:

```
mix.fastSass('resources/assets/sass/app.scss', 'public/css');
```

But unless i really need to save time, i keep it like so:

```
mix.sass('resources/assets/sass/app.scss', 'public/css');
```

Next, run the following command to compile the sass file down to css:

During development : `npm run watch`.

For production: `npm run prod` or `npm run production` 

## All set
You should now be all set to go.

## Next up..
In a coming post, ill go over vue/javascript as well as a mix option `purify`
