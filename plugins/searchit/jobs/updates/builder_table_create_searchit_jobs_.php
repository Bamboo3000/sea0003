<?php namespace Searchit\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSearchitJobs extends Migration
{
    public function up()
    {
        Schema::create('searchit_jobs_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('summary');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('searchit_jobs_');
    }
}
