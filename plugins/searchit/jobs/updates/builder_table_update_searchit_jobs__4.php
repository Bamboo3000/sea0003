<?php namespace Searchit\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSearchitJobs4 extends Migration
{
    public function up()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->string('slug', 255);
        });
    }
    
    public function down()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
