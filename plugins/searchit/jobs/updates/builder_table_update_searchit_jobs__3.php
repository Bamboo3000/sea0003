<?php namespace Searchit\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSearchitJobs3 extends Migration
{
    public function up()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->integer('job_id');
        });
    }
    
    public function down()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->dropColumn('job_id');
        });
    }
}
