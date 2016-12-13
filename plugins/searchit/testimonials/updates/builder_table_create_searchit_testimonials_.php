<?php namespace Searchit\Testimonials\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSearchitTestimonials extends Migration
{
    public function up()
    {
        Schema::create('searchit_testimonials_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('summary');
            $table->string('who');
            $table->string('type');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('searchit_testimonials_');
    }
}
