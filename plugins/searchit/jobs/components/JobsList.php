<?php namespace Searchit\Jobs\Components;

use Cms\Classes\ComponentBase;
use Searchit\Jobs\Models\Job;
use Searchit\Jobs\Models\Type;
use Searchit\Jobs\Models\Category;

class JobsList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Jobs List Component',
            'description' => 'No description provided yet...'
        ];
    }

    public $jobs;
    public $cats;
    public $types;

    public function init() {
        $this->page['jobs'] = Job::paginate(16);
        $this->page['cats'] = Category::get();
        $this->page['types'] = Type::get();
    }

}