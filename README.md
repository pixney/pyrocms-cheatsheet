# Pyro - A Laravel Development Platform

[Installing Pyrocms 3.4](installing_pyrocms_3.md)  
[Using mix with pyrocms](using_mix.md)  
[Organising fields in tabs for pages and posts](https://github.com/designbywilliam/pyrocms-cheatsheet/wiki/Organising-fields-in-tabs-for-pages-and-posts)  
[Customising Repeater Views](https://github.com/designbywilliam/pyrocms-cheatsheet/wiki/How-to-customise-repeater-views)  

## Upgrading
Always read Ryans blog posts. But in general just use the composer.json file of the version you want to upgrade to. Then:

```
composer update
php artisan migrate --path=vendor/anomaly/streams-platform/migrations/application
php artisan migrate --all-addons
php artisan assets:clear
php artisan cache:clear
php artisan view:clear
php artisan twig:clear
```

## Migrations
[Create a grid and attach it to default_posts stream](migration_grid_to_posts.md)  
[Create a grid with image field type](create_grid.php)  

## Seeders

[Seed page and blocks](AboutSeeder.php)  


## Seeding

* **Create seed** `php artisan make:seeder GridSeeder`  
* **Run seed** `php artisan db:seed --class=GridSeeder`
* **Seed Addon** `php artisan db:seed --addon=[addon]`

## Module/Extension
* **Create Addon**  `php artisan make:addon my_project.module.library`  
* **Create Stream**  `php artisan make:stream books my_project.module.library`  
* **Install Module**  `php artisan module:install my_project.module.library`  
* **UnInstall Module**  `php artisan module:uninstall my_project.module.library`  
* **ReInstall Module**  `php artisan module:reinstall my_project.module.library`  
* **ReInstall & Seed Module**  `php artisan module:reinstall my_project.module.library --seed`  
* **Publish Addon**  `php artisan addon:publish library`

## Migration
* **Default Migration** : `php artisan make:migration create_more_fields --addon=example.module.test`
* **Field Migration** : `php artisan make:migration create_more_fields --addon=example.module.test --fields`
* **Stream Migrations** : `php artisan make:migration create_example_stream --addon=example.module.test --stream=widgets`
* **Run Migration** : `php artisan migrate --all-addons`

## Addon
* **Create Addon** `php artisan make:addon my_project.plugin.widget`

## Publish Commands
* **Publish all addons to the resources/{ref}/addons folder** `php artisan addon:publish`
* **Publish streams configuration to resources/streams** `php artisan streams:publish`
* **Publish posts module only** `php artisan addon:publish anomaly.module.posts`
* **Publish for an app other than the default one** `php artisan addon:publish anomaly.module.posts --app=my_ref`
* **Publish streams config for an app other than your default one** `php artisan streams:publish --app=my_ref`

## Images
* **Crop image from top instead of center** `{{ thumbnail.image().fit(400, 400, null,'top')|raw }}` [Position](http://image.intervention.io/api/fit)

## Field Types
### WYSIWYG - Changing Redactor configuration.
To simplify for a user you might want to edit the buttons displayed. It can be done by
publishing the field type using the following command `php artisan addon:publish anomaly.field_type.wysiwyg`.

But you could also do it in a migration when creating the field type. The important step here, is
to make sure you clear the configuration. And then use plugins and buttons to set what should be 
available. 

```
"example" => [
    "type"   => "anomaly.field_type.wysiwyg",
    "config" => [
        "default_value" => null,
        "configuration" => "default",
        "line_breaks"   => false,
        "sync"          => true,
        "height"        => 500,
        "buttons"       => ['bold','lists','link'],
        "plugins"       => ['source','fullscreen'],
    ]
]
```

### Modify field type configuration
``` 
    public function up()
    {
        $metaDescriptionConfig = [
            'min' => null,
            'max' => 290,
        ];

        if ($field = $this->fields()->findBySlugAndNamespace('meta_description', 'pages')) {
            $field->setAttribute('instructions', 'Meta descriptions are HTML attributes that provide concise summaries of webpages. They are between one sentence to a short paragraph and appear underneath the blue clickable links in a search engine results page (SERP).')->save();
            $field->setAttribute('warning', 'When left empty, the website will try to use the page introduction field. However, depending on a user\'s query, Google might pull meta description text from other areas on your page (in an attempt to better answer the searcher\'s query)')->save();
            $field->setAttribute('config', $metaDescriptionConfig)->save();
        };

        if ($field = $this->fields()->findBySlugAndNamespace('meta_title', 'pages')) {
            $field->setAttribute('instructions', "A title tag is an HTML element that specifies the title of a web page. Title tags are displayed on search engine results pages (SERPs) as the clickable headline for a given result, and are important for usability, SEO, and social sharing. The title tag of a web page is meant to be an accurate and concise description of a page's content.")->save();
            $field->setAttribute('warning', 'When field is left empty, the website will try using the main title of the page.')->save();
        };
    }
```

## Files / Images 
* **/app/project/files/local/images/d61b5c3d5ea2bb829cbfbd05e68477b3.jpg?v=1513155180** `{{image('local://images/blackjaq.jpg').fit(500,300).quality(100).path()}}`
## Request

### Get current paths
* **http://domain.com** `{{ request_root() }}`
* **http://domain.com/path** `{{request_url()}}`
* **http://domain.com/path** `{{request_fullUrl()}}`
* **path/to/a/post** `{{ request_path() }}`

### Url Parameters

* **http://domain.com?foo=bar**  `{{ request_get("foo") }} == bar`
* **GET**  `{{ request_method() }}`
* **http://domain.com/post/number-one**  `{{ request_segment(1) }} == post`

### Booleans
* **boolean**  `{{ request_is("myaccount/*", "account/*") }} `
* **boolean**  `{{ request_ajax() }} `
 
## Route

* **bar**   : `{{ route_parameter("foo", "default") }} `
* **["foo" => "bar"]**   : `{{ route_parameters() }} `
* **/the/path/example**   : `{{ route_uri() }} `
* **boolean**   : `{{ route_secure() }} `
* **example.com**   : `{{ route_domain() }} `
* **the route name if any**   : `{{ route_get_name() }} `
* **Back to previous page** : `url_previous()`

## Url

* **"http://domain.com/example"** : `{{ url_to("example") }} `
* **"https://domain.com/example"** : `{{ url_secure("example") }} `
* **"users/password/forgot"** : `{{ url_route("anomaly.module.users::password.forgot") }} `

## Session
* **"bar"**   : `{{ session_get("foo") }} `
* **"bar"**   : `{{ session_pull("foo") }} `
* **null**   : `{{ session_pull("foo") }} `
* **boolean**   : `{{ session_has("foo") }} `

## Settings
* **Get a settings value in twig**  :  `{{ setting('streams::name') }}`

Getting a settings value in php:

```
$settings = app(SettingRepositoryInterface::class);
$listId = $settings->value('pixney.module.campaigns::listId');
```

## Available Events
Thanks @squatto
```
Anomaly\Streams\Platform\Addon\Addon->fire('entry_created')
Anomaly\Streams\Platform\Addon\Addon->fire('entry_creating')
Anomaly\Streams\Platform\Addon\Addon->fire('entry_deleted')
Anomaly\Streams\Platform\Addon\Addon->fire('entry_saved')
Anomaly\Streams\Platform\Addon\Addon->fire('entry_updated')
Anomaly\Streams\Platform\Addon\Addon->fire('form_posted')
Anomaly\Streams\Platform\Addon\Addon->fire('form_posting')
Anomaly\Streams\Platform\Addon\Addon->fire('form_saved')
Anomaly\Streams\Platform\Addon\Addon->fire('form_saving')
Anomaly\Streams\Platform\Addon\Addon->fire('registered')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('built')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('make')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('post')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('posted')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('posting')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('querying')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('ready')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('saved')
Anomaly\Streams\Platform\Ui\Form\FormBuilder->fire('saving')
Anomaly\Streams\Platform\Ui\Table\Component\View\View->fire('querying')
Anomaly\Streams\Platform\Ui\Table\TableBuilder->fire('built')
Anomaly\Streams\Platform\Ui\Table\TableBuilder->fire('querying')
Anomaly\Streams\Platform\Ui\Table\TableBuilder->fire('ready')
Anomaly\Streams\Platform\Ui\Table\TableBuilder->fire('row_deleted')
Anomaly\Streams\Platform\Ui\Table\TableBuilder->fire('rows_deleted')
```


## String
### Hello World
```
{{ str_humanize("hello_world") }} 
{{ str_truncate(string, 100) }}

{% if str_is("*.module.*", addon("users").namespace) %}
    That's a valid module namespace!
{% endif %}
```

* **"someSlug"** : `{{ str_camel("some_slug") }} `
* **"SomeSlug"** : `{{ str_studly("some_slug") }} `
* **4sdf87yshs** : `{{ str_random(10) }}`
 
## Translator

* **"Users Module"** : `{{ trans("anomaly.module.users::addon.name") }} `
* **boolean** : `{{ trans_exists("anomaly.module.users::field.bogus.name") }} `

## Hreflang
```
{# {% for locale in config_get('streams::locales.enabled') %} #}
{% set lq = request_getQueryString() %}
{% for locale in ['en', 'sv'] %}
<link rel="alternate" href="{{ url_locale(request_path(), locale) }}" hreflang="{{locale}}" title=""/>
{% endfor %}
```

## Locale switch
```
<div class="locales">
    {% set query = request_getQueryString() %} 
    {# {% for locale in config_get('streams::locales.enabled') %} #}
    {% for locale in ['en','sv',] %}
    <a 
    {{ config( 'app.locale')==locale ? 'class="current"'}}
    href="{{ url_locale(request_path(), locale) }}{{ query ? '?'~query }}">
        {{ locale }}
    </a>
    {% endfor %}
</div>
```

## Redirecting WWW.DOMAIN.COM -> DOMAIN.COM
Create a middle wear as below, and then simply add it to the middlewarecollection. This is done by using the middleware attribute in your service provider.

```
protected $middleware = [
    Http\Middleware\NonWWWMiddleware::class
];
```

```
<?php

namespace Pixney\ThidrandiTheme\Http\Middleware;

use Closure;

/**
 * Class NonWWWMiddleware
 *
 *  @author Pixney AB <hello@pixney.com>
 *  @author William Åström <william@pixney.com>
 *  
 *  @link https://pixney.com
 */
use Illuminate\Support\Facades\Redirect;


class NonWWWMiddleware
{
    public function handle($request, Closure $next)
    {
        if (starts_with($request->header('host'), 'www.')) {
            $host = str_replace('www.', '', $request->header('host'));
            $request->headers->set('host', $host);

            return Redirect::to($request->fullUrl(), 301);
        }

        return $next($request);
    }
}
```


## Other kinky stuff
_The `memory_usage ` function returns the memory used by the request._  
`{{ memory_usage() }}`

_The `request_time ` function returns the elapsed time for the request._  
`{{ request_time(3) }}`  

## Minify Html
`composer require nochso/html-compress-twig`

Edit : `config/twigbridge.php`

```
'enabled' => [
    'TwigBridge\Extension\Loader\Functions',
    function() {
        return new \nochso\HtmlCompressTwig\Extension(true);
    }
]
```

Add this to your layout(s)

```
{% htmlcompress %}
Your html
{% endhtmlcompress %}
```

# Custom
* **Svgstore tag** `<svg><use xlink:href="#logo" /></svg>`

### Twitter

https://dev.twitter.com/cards/types/summary-large-image

```
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@nytimes">
<meta name="twitter:creator" content="@SarahMaslinNir">
<meta name="twitter:title" content="Parade of Fans for Houston’s Funeral">
<meta name="twitter:description" content="NEWARK - The guest list and parade of limousines with celebrities emerging from them seemed more suited to a red carpet event in Hollywood or New York than than a gritty stretch of Sussex Avenue near the former site of the James M. Baxter Terrace public housing project here.">
<meta name="twitter:image" content="http://graphics8.nytimes.com/images/2012/02/19/us/19whitney-span/19whitney-span-articleLarge.jpg">
```

### SEO Cheat Sheets

https://moz.com/blog/seo-cheat-sheet  
http://www.sharelinkgenerator.com/

### Other development related links
* [Meta tags](https://megatags.co/) 
* [Sharing buttons](http://sharingbuttons.io/)



### Laravel MIX 4 and SVG Spritemap plugin
```
npm uninstall svg-spritemap-webpack-plugin
npm install svg-spritemap-webpack-plugin --save-dev
const svgSourcePath = "resources/assets/svgs/*.svg";
const svgSpriteDestination="resources/views/svgs.blade.php";

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .webpackConfig({
      plugins: [
         new SVGSpritemapPlugin(
            svgSourcePath, {
               output: {
                  filename: svgSpriteDestination,
                  svgo: true
               },
            }
         )
      ]
   })
   .version([]).sourceMaps();
```



### Russian Stuff
```
alias composer="php ~/composer.phar -vv"
alias gitp="bash ~/scripts/gitpush.sh"

alias artis="php artisan -vvv"
alias pserve="php -S localhost:8800"
alias arclearall="artis view:clear && artis route:clear && artis cache:clear && artis twig:clean && artis asset:clear && artis clear-compiled"

alias ace='node ace'

alias perm_d="find . -type d -exec chmod 755 {} +"
alias perm_f="find . -type f -exec chmod 644 {} +"

## Forms Module
If we are using the (PRO) Forms module and want to render our own custom stuff we can simply do :

```

```
// Get the form and set it to redirect to our homepage if its successfully submitted.
{% set form = form('forms','your_form_slug').redirect('/').get() %}

// Catch the errors
{% if form.hasErrors %}
	Errors
	{% for key,errors in form.errors.messages %}
		{{key}}
		{% for error in errors %}
		    {{error}}
		{% endfor %}
	{% endfor %}
{% endif %}

// Our form output, that you will use to style your form your way
{{ form.open({'class':'williams_contact_form'})|raw }}
	{{ form.fields.name|raw }}
	{{ form.fields.email|raw }}
	{{ form.fields.message|raw }}
	<button>Send</button>
{{ form.close|raw }}
```

https://laravel-news.com/bash-aliases
