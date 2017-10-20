# Pyro - A Laravel Development Platform

[Installing Pyrocms 3.4](installing_pyrocms_3.md)  
[Using mix with pyrocms](using_mix.md)  

## Mirgations
[Create a grid with image field type](create_grid.php)  

## Seeding

* **Create seed** `php artisan make:seeder GridSeeder`  
* **Run seed** `php artisan db:seed --class=GridSeeder`

## Module
* **Create Module**  `php artisan make:addon my_project.module.library`  
* **Create Stream**  `php artisan make:stream books my_project.module.library`  
* **Install Module**  `php artisan module:install my_project.module.library`  
* **UnInstall Module**  `php artisan module:uninstall my_project.module.library`  
* **ReInstall Module**  `php artisan module:reinstall my_project.module.library`  
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


## Route

* **bar**   : `{{ route_parameter("foo", "default") }} `
* **["foo" => "bar"]**   : `{{ route_parameters() }} `
* **/the/path/example**   : `{{ route_uri() }} `
* **boolean**   : `{{ route_secure() }} `
* **example.com**   : `{{ route_domain() }} `
* **the route name if any**   : `{{ route_get_name() }} `
* **Back to previous page** : `url_previous()`

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

## Locale switch
```
<div class="locales">
	{% set query = request_getQueryString() %}
	{# {% for locale in config_get('streams::locales.enabled') %} #}
	{% for locale in ['en', 'sv',] %}
		<a
			{% if config('app.locale') == locale %}class="current"{% endif %}
			href="{{ url_locale(request_path(), locale) }}{% if query %}?{{ query }}{% endif %}">
			{{ locale }}
		</a>
	{% endfor %}
</div>
```

## Url

* **"http://domain.com/example"** : `{{ url_to("example") }} `
* **"https://domain.com/example"** : `{{ url_secure("example") }} `
* **"users/password/forgot"** : `{{ url_route("anomaly.module.users::password.forgot") }} `

## Request
* **bar** : {{ request_get("foo") }} 
* **GET** : {{ request_method() }} 
* **http://** : `{{ request_root() }}`
* **/path** : `{{ request_path() }}`
* **foo** : `{{ request_segment(1) }}` 
* **123** : `{{ request().route('id') }} `
* **boolean** : `{{ request_is("myaccount/*", "account/*") }} `
* **boolean** : `{{ request_ajax() }} `

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
