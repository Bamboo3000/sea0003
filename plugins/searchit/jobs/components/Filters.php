<?php namespace Searchit\Jobs\Components;

use Cms\Classes\ComponentBase;
use Searchit\Jobs\Models\Job;

class Filters extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Filter Component',
            'description' => 'No description provided yet...'
        ];
    }

    // public function onRun() 
    // {
    //     $this->categories = $this->getCategories();
    // }

    // public $categories;
    // public $types;

    /*
    *
    * Return categories column
    *
    */
    protected function onFilterSearch()
    {
        $query = input('job-title');

        $this->search = Job::where('title', 'LIKE', "%{$query}%")
        ->orderBy('date', 'desc')
        ->get();

        return [
            $this->page['result'] = $this->search
        ];

    }

    public $search;

}