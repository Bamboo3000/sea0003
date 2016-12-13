<?php namespace Searchit\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSearchitJobs extends Migration
{
    public function up()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->string('category');
            $table->dateTime('date');
        });
    }
    
    public function down()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->dropColumn('category');
            $table->dropColumn('date');
        });
    }
}
