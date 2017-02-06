<?php namespace Searchit\Jobs;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Searchit\Jobs\Components\Cronjob' => 'cronjob',
    		// 'Searchit\Jobs\Components\Filters' => 'job-filters',
            'Searchit\Jobs\Components\Sidebar' => 'sidebar',
            'Searchit\Jobs\Components\Form' => 'form'
    	];
    }

    public function registerSettings()
    {
    }
}
