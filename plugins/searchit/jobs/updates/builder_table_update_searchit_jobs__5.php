<?php namespace Searchit\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSearchitJobs5 extends Migration
{
    public function up()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->integer('salary_min')->nullable(false)->unsigned(false)->default(null)->change();
            $table->integer('salary_max')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('searchit_jobs_', function($table)
        {
            $table->string('salary_min', 255)->nullable(false)->unsigned(false)->default(null)->change();
            $table->string('salary_max', 255)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
