<?php namespace Searchit\Testimonials\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSearchitTestimonials extends Migration
{
    public function up()
    {
        Schema::table('searchit_testimonials_', function($table)
        {
            $table->boolean('featured');
        });
    }
    
    public function down()
    {
        Schema::table('searchit_testimonials_', function($table)
        {
            $table->dropColumn('featured');
        });
    }
}
