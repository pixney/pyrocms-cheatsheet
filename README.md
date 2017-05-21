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

## Addon
* **Create Addon** `php artisan make:addon my_project.plugin.widget`

## Publish Commands
* **Publish all addons to the resources/{ref}/addons folder** `php artisan addon:publish`
* **Publish streams configuration to resources/streams** `php artisan streams:publish`
* **Publish posts module only** `php artisan addon:publish anomaly.module.posts`
* **Publish for an app other than the default one** `php artisan addon:publish anomaly.module.posts --app=my_ref`
* **Publish streams config for an app other than your default one** `php artisan streams:publish --app=my_ref`

## Field Types
* **Text** `anomaly.field_type.text`
* **Textarea** `anomaly.field_type.textarea`

## Route

* **bar**   : `{{ route_parameter("foo", "default") }} `
* **["foo" => "bar"]**   : `{{ route_parameters() }} `
* **/the/path/example**   : `{{ route_uri() }} `
* **boolean**   : `{{ route_secure() }} `
* **example.com**   : `{{ route_domain() }} `
* **the route name if any**   : `{{ route_get_name() }} `

## Session
* **"bar"**   : `{{ session_get("foo") }} `
* **"bar"**   : `{{ session_pull("foo") }} `
* **null**   : `{{ session_pull("foo") }} `
* **boolean**   : `{{ session_has("foo") }} `

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

