<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class CreateGrid extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        |--------------------------------------------------------------------------
        | Create Grid
        |--------------------------------------------------------------------------
        |
         */
        $stream = $this->streams()->create([
            "namespace" => "grid",
            "name"      => "Grid",
            "slug"      => "grid",
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create field
        |--------------------------------------------------------------------------
        |
        |
         */
        $field = $this->fields()->create([
            "namespace" => "grid",
            "type"      => "anomaly.field_type.image",
            "slug"      => "image_3_2",
            "name"      => "Image Ratio 3:2",
            "locked"    => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign the field to the stream
        |--------------------------------------------------------------------------
        |
        |
         */
        $this->assignments()->create(
            [
                'stream'       => $stream,
                'field'        => $field,
                'unique'       => false,
                'required'     => false,
                'translatable' => false,
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $stream     = $this->streams()->findBySlugAndNamespace('grid', 'grid');
        $field      = $this->fields()->findBySlugAndNamespace('image_3_2', 'grid');
        $assignment = $this->assignments()->findByStreamAndField($stream, $field);

        $field->delete();
        $stream->delete();
        $assignment->delete();
    }
}
