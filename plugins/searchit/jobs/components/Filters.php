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

    public $jobs;

    public function init()
    {
        
    }

    /*
    *
    * Return categories column
    *
    */
    public function onFilterSearch()
    {
        $title = input('job-title');
        $type = input('job-type');
        $location = input('job-location');
        $category = input('job-category');
        $salaryMin = input('job-salary-min');
        $salaryMax = input('job-salary-max');
        
        if(!empty($salaryMin) && !empty($salaryMax)) {
            $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->whereHas('categories', function($query) use ($category) {
                $query->where('category_name', 'LIKE', "%{$category}%");
            })
            ->whereHas('types', function($query) use ($type) {
                $query->where('type_name', 'LIKE', "%{$type}%");
            })
            ->where('salary_min', '>=', $salaryMin)
            ->where('salary_max', '<=', $salaryMax)
            ->orderBy('date', 'desc')
            ->paginate(16);
        } elseif(!empty($salaryMin)) {
            $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->whereHas('categories', function($query) use ($category) {
                $query->where('category_name', 'LIKE', "%{$category}%");
            })
            ->whereHas('types', function($query) use ($type) {
                $query->where('type_name', 'LIKE', "%{$type}%");
            })
            ->where('salary_min', '>=', $salaryMin)
            ->orderBy('date', 'desc')
            ->paginate(16);
        } elseif(!empty($salaryMax)) {
            $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->whereHas('categories', function($query) use ($category) {
                $query->where('category_name', 'LIKE', "%{$category}%");
            })
            ->whereHas('types', function($query) use ($type) {
                $query->where('type_name', 'LIKE', "%{$type}%");
            })
            ->where('salary_max', '<=', $salaryMax)
            ->orderBy('date', 'desc')
            ->paginate(16);
        } else {
            $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->whereHas('categories', function($query) use ($category) {
                $query->where('category_name', 'LIKE', "%{$category}%");
            })
            ->whereHas('types', function($query) use ($type) {
                $query->where('type_name', 'LIKE', "%{$type}%");
            })
            ->orderBy('date', 'desc')
            ->paginate(16);
        }    

    }

    // protected function onFilterSearch()
    // {
    //     $title = input('job-title');
    //     $type = input('job-type');
    //     $location = input('job-location');
    //     $category = input('job-category');
    //     $salaryMin = input('job-salary-min');
    //     $salaryMax = input('job-salary-max');

    //     if(!empty($salaryMin) && !empty($salaryMax)) {
    //         $this->search = Job::where('title', 'LIKE', "%{$title}%")
    //         ->where('location', 'LIKE', "%{$location}%")
    //         // ->where('category', 'LIKE', "%{$category}%")
    //         // ->where('type', 'LIKE', "%{$type}%")
    //         ->where('salary_min', '>=', $salaryMin)
    //         ->where('salary_max', '<=', $salaryMax)
    //         ->orderBy('date', 'desc')
    //         ->get();
    //     } elseif(!empty($salaryMin)) {
    //         $this->search = Job::where('title', 'LIKE', "%{$title}%")
    //         ->where('location', 'LIKE', "%{$location}%")
    //         // ->where('category', 'LIKE', "%{$category}%")
    //         // ->where('type', 'LIKE', "%{$type}%")
    //         ->where('salary_min', '>=', $salaryMin)
    //         ->orderBy('date', 'desc')
    //         ->get();
    //     } elseif(!empty($salaryMax)) {
    //         $this->search = Job::where('title', 'LIKE', "%{$title}%")
    //         ->where('location', 'LIKE', "%{$location}%")
    //         // ->where('category', 'LIKE', "%{$category}%")
    //         // ->where('type', 'LIKE', "%{$type}%")
    //         ->where('salary_max', '<=', $salaryMax)
    //         ->orderBy('date', 'desc')
    //         ->get();
    //     } else {
    //         $this->search = Job::where('title', 'LIKE', "%{$title}%")
    //         ->where('location', 'LIKE', "%{$location}%")
    //         // ->where('category', 'LIKE', "%{$category}%")
    //         // ->where('type', 'LIKE', "%{$type}%")
    //         ->orderBy('date', 'desc')
    //         ->get();
    //     }

    //     return [
    //         $this->page['result'] = $this->search
    //     ];

    // }

    /*
    *
    * Return the number of rows founded
    *
    */
    // public function getCatCount($value)
    // {
    //     return Job::where('category', 'LIKE', "%{$value}%")->count();
    // }

}