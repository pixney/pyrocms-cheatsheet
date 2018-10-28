# Create a repeater with fields attached to our default posts

## create_posts_repeater_fields
`php artisan make:migration create_posts_repeater_fields`

```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class CreateBookSliderRepeaterFields extends Migration
{
    protected $namespace = 'repeater';

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'posts_repeater_content'=> [
            'type'   => 'anomaly.field_type.wysiwyg',
            'name'   => 'Content',
            'locked' => false,
            'config' => [
                "default_value" => null,
                "configuration" => "default",
                "line_breaks"   => false,
                "sync"          => true,
                "height"        => 500,
            ]
        ],
        'posts_repeater_image' => [
            'type'   => 'anomaly.field_type.image',
            'name'   => 'Image - Full width',
            'locked' => false,
            'config' => [
                'aspect_ratio'  => '16:9',
                'min_height'    => 400,
                "folders"       => ['blog'],
            ]
        ],
    ];
}
```