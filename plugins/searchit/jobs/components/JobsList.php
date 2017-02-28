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
    public $pagination;

    public function init()
    {
      $this->page['cats'] = Category::get();
      $this->page['types'] = Type::get();

      $title = input('job-title');
      $type = input('job-type');
      $location = input('job-location');
      $category = input('job-category');
      $salaryMin = input('job-salary-min');
      $salaryMax = input('job-salary-max');

      $parameters = [];
      $params = [
	        'job-title',
	        'job-type',
	        'job-location',
	        'job-category',
	        'job-salary-min',
	        'job-salary-max'
	    ];
      foreach ($params as $param) {
	        $parameters[$param] = input($param);
	    }

      if(!empty($salaryMin) && !empty($salaryMax)) {
          $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
          ->where('location', 'LIKE', "%{$location}%")
          ->whereHas('categories', function($query) use ($category) {
              $query->where('category_slug', 'LIKE', "%{$category}%");
          })
          ->whereHas('types', function($query) use ($type) {
              $query->where('type_slug', 'LIKE', "%{$type}%");
          })
          ->where('salary_min', '>=', $salaryMin)
          ->where('salary_max', '<=', $salaryMax)
          ->orderBy('date', 'desc')
          ->paginate(16);
      } elseif(!empty($salaryMin)) {
          $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
          ->where('location', 'LIKE', "%{$location}%")
          ->whereHas('categories', function($query) use ($category) {
              $query->where('category_slug', 'LIKE', "%{$category}%");
          })
          ->whereHas('types', function($query) use ($type) {
              $query->where('type_slug', 'LIKE', "%{$type}%");
          })
          ->where('salary_min', '>=', $salaryMin)
          ->orderBy('date', 'desc')
          ->paginate(16);
      } elseif(!empty($salaryMax)) {
          $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
          ->where('location', 'LIKE', "%{$location}%")
          ->whereHas('categories', function($query) use ($category) {
              $query->where('category_slug', 'LIKE', "%{$category}%");
          })
          ->whereHas('types', function($query) use ($type) {
              $query->where('type_slug', 'LIKE', "%{$type}%");
          })
          ->where('salary_max', '<=', $salaryMax)
          ->orderBy('date', 'desc')
          ->paginate(16);
      } else {
          $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
          ->where('location', 'LIKE', "%{$location}%")
          ->whereHas('categories', function($query) use ($category) {
              $query->where('category_slug', 'LIKE', "%{$category}%");
          })
          ->whereHas('types', function($query) use ($type) {
              $query->where('type_slug', 'LIKE', "%{$type}%");
          })
          ->orderBy('date', 'desc')
          ->paginate(16);
      }

      $this->page['pagination'] = $this->page['jobs']->appends($parameters);

    }

    public function onFilterSearch()
    {
        $title = input('job-title');
        $type = input('job-type');
        $location = input('job-location');
        $category = input('job-category');
        $salaryMin = input('job-salary-min');
        $salaryMax = input('job-salary-max');

        $parameters = [];
        $params = [
  	        'job-title',
  	        'job-type',
  	        'job-location',
  	        'job-category',
  	        'job-salary-min',
  	        'job-salary-max'
  	    ];
        foreach ($params as $param) {
  	        $parameters[$param] = input($param);
  	    }

        if(!empty($salaryMin) && !empty($salaryMax)) {
            $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->whereHas('categories', function($query) use ($category) {
                $query->where('category_slug', 'LIKE', "%{$category}%");
            })
            ->whereHas('types', function($query) use ($type) {
                $query->where('type_slug', 'LIKE', "%{$type}%");
            })
            ->where('salary_min', '>=', $salaryMin)
            ->where('salary_max', '<=', $salaryMax)
            ->orderBy('date', 'desc')
            ->paginate(16);
        } elseif(!empty($salaryMin)) {
            $this->page['jobs'] = Job::where('title', 'LIKE', "%{$title}%")
            ->where('location', 'LIKE', "%{$location}%")
            ->whereHas('categories', function($query) use ($category) {
                $query->where('category_slug', 'LIKE', "%{$category}%");
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
                $query->where('category_slug', 'LIKE', "%{$category}%");
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
                $query->where('category_slug', 'LIKE', "%{$category}%");
            })
            ->whereHas('types', function($query) use ($type) {
                $query->where('type_slug', 'LIKE', "%{$type}%");
            })
            ->orderBy('date', 'desc')
            ->paginate(16);
        }

        $this->page['pagination'] = $this->page['jobs']->appends($parameters);

    }

}
