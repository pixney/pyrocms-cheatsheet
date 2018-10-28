# Create a repeater with fields attached to our default posts

## create_posts_repeater_fields
`php artisan make:migration create_posts_repeater_fields`

```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class CreatePostsRepeaterFields extends Migration
{
    protected $namespace = 'repeater';

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'posts_content'=> [
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
        'posts_image' => [
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

## create_posts_repeater_stream
`php artisan make:migration create_posts_repeater_stream`

```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class CreatePostsRepeaterStream extends Migration
{
    protected $namespace = 'repeater';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'posts_repeater',
        'name'         => 'Posts Repeater',
        'translatable' => true,
        'versionable'  => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'posts_content'=> [
            'translatable' => false,
            'required'     => true,
        ],
        'posts_image'=> [
            'translatable' => false,
            'required'     => true,
        ]
    ];
}


```

## assign_posts_repeater_to_default_posts
`php artisan make:migration assign_posts_repeater_to_default_posts`

```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AssignPostsRepeaterToDefaultPosts extends Migration
{
    protected $delete    = false;
    protected $namespace ='posts';

    protected $stream = [
        'slug' => 'default_posts',
    ];

    /**
     * These assignments will be
     * created for the stream above.
     */
    protected $assignments = [
        'blog_grid'
    ];

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'blog_grid'=> [
            'type'   => 'anomaly.field_type.repeater',
            'name'   => 'Content',
            'locked' => false,
            'config' => [
                "related"        => "repeater.posts_repeater",
            ]
        ]
    ];
}
```