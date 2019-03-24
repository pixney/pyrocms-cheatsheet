# Creating a block extension
This is my way of doing it. It probably differs a lot from how everyone else would go
around doing it. But i like to have control of my block views within my theme,
not within the block itself. The reason for that is i tend to build sites differently
each time with different type of layouts but still want to be able to reuse blocks.

An example, is a block with an editor and an image. I keep the basics to the extension
but then how it would look on the website i wanna be able to control within my theme because
on different websites, the block itself would be styled in different ways, but i always
need an editor and an image block.

## Follow Ryans guide
[I start with following Ryans suggestions here.](https://pyrocms.com/documentation/blocks-module/1.0/developers/blocks)

### Create the extension
```
php artisan make:addon my_company.extension.awesome_block
```

### Make sure the extension extends BlockExtension
```
use Anomaly\BlocksModule\Block\BlockExtension;
```

### Creating a block stream
```
php artisan make:stream blocks awesome_block
```

## My custom block extension

This is how i write my block extension which allows me to
keep the views of my block within my theme and the blocks directory.


```
<?php

namespace Pixney\WysiwygImageBlockExtension;

use Anomaly\BlocksModule\Block\BlockExtension;
use Pixney\WysiwygImageBlockExtension\Block\BlockModel;
use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;

class WysiwygImageBlockExtension extends BlockExtension
{
    protected $provides = 'anomaly.module.blocks::block.wysiwyg_image';
    protected $model    = BlockModel::class;

    public function getView()
    {
        $settings      = app(SettingRepositoryInterface::class);
        $setting       = $settings->get('streams::standard_theme');
        $this->wrapper = $setting->value . '::blocks/global/wrapper';
        return $setting->value . '::blocks/wysiwyg';
    }
}
```


## Example: pixney/pixney-theme/resources/views/blocks/wysiwyg.twig

```
<div class="m-wysiwyg {{ block.classes }}">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 col-xxl-8 mx-auto">
                <div class="row">
                    <div class="col-12">
                        <div class="m-wysiwyg__content">
                            {{ block.content.render|raw }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Example: pixney/pixney-theme/resources/views/blocks/global/wrapper.twig
```
<div class="a-section -{{ block.extension.value.slug }}">

    {{ content|raw }}

</div>
```