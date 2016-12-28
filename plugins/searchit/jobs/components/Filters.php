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
        $title = input('job-title');
        $location = input('job-location');
        $salaryMin = input('job-salary-min');
        $salaryMax = input('job-salary-max');

        if(!empty($salaryMin) && !empty($salaryMax)) {
            $this->search = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->where('salary_min', '>=', $salaryMin)
            ->where('salary_max', '<=', $salaryMax)
            ->orderBy('date', 'desc')
            ->get();
        } elseif(!empty($salaryMin)) {
            $this->search = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->where('salary_min', '>=', $salaryMin)
            ->orderBy('date', 'desc')
            ->get();
        } elseif(!empty($salaryMax)) {
            $this->search = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->where('salary_max', '<=', $salaryMax)
            ->orderBy('date', 'desc')
            ->get();
        } else {
            $this->search = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->orderBy('date', 'desc')
            ->get();
        }

        return [
            $this->page['result'] = $this->search
        ];

    }

    public $search;

}