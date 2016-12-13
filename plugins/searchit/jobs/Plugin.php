<?php namespace Searchit\Jobs;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Searchit\Jobs\Components\Cronjob' => 'cronjob'
    		// 'Searchit\Jobs\Components\Filters' => 'job-filters'
    	];
    }

    public function registerSettings()
    {
    }
}
