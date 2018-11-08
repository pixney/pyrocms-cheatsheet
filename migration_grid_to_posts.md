# Add a grid to posts
I would like to use a grid when populating my post with content. To accomplish 
that programmatically i have to go through a couple of quick steps:

* Create the fields i need in the grid namespace.
* Create the grid i need and assign the previously created fields to it.
* Finally i assign the grid to the default_posts stream.

When you are done, simply run : `php artisan migrate`. If you would like to
change something you can always rollback the migration by
`php artisan migrate:rollback --step=x` where x is the number of migrations
you would like to undo.

## Create the fields i need in the grid namespace.
```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class CreateBlogGridFields extends Migration
{
    protected $namespace = 'grid';

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
        'posts_image_caption'=> [
            'type'   => 'anomaly.field_type.text',
            'name'   => 'Image Caption',
            'locked' => false,
            'config' => [
                "type"          => "text"
            ]
        ],
        'posts_image' => [
            'type'   => 'anomaly.field_type.image',
            'name'   => 'Image',
            'locked' => false,
            'config' => [
                "folders"       => ['blog'],
            ]
        ],
      
    ];
}

```
## Create the grid i need and assign the previously created fields to it.
```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class CreateBlogGridImage extends Migration
{
    protected $namespace = 'grid';

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug'         => 'grid_image',
        'name'         => 'Image',
        'translatable' => true,
        'versionable'  => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'posts_image'=> [
            'translatable' => false,
            'required'     => true,
        ],
        'posts_image_caption'=> [
            'translatable' => false,
            'required'     => false,
        ]
    ];
}
```
## Finally i assign the grid to the default_posts stream.
```
<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AssignBlogGridToDefaultPages extends Migration
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
            'type'   => 'anomaly.field_type.grid',
            'name'   => 'Content',
            'locked' => false,
            'config' => [
                "related"        => [],
            ]
        ]
    ];
}

```