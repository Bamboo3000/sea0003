<?php namespace Searchit\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSearchitJobs2 extends Migration
{
    public function up()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->string('type');
            $table->string('salary_min');
            $table->string('salary_max');
            $table->string('location');
            $table->string('lat');
            $table->string('lng');
        });
    }
    
    public function down()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->dropColumn('type');
            $table->dropColumn('salary_min');
            $table->dropColumn('salary_max');
            $table->dropColumn('location');
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
    }
}
