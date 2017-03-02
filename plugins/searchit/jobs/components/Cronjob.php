<?php namespace Searchit\Jobs\Components;

use Cms\Classes\ComponentBase;
use Searchit\Jobs\Models\Job;
use Searchit\Jobs\Models\Category;
use Searchit\Jobs\Models\Type;
use Illuminate\Support\Facades\DB;

class Cronjob extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Cronjob Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            $this->readFile();
        })->everyTenMinutes();->withoutOverlapping()->emailOutputTo('pabis91@gmail.com');;
    }

    public function onRun() 
    {
        $this->readFile();
    }

    public $vacancy;

    protected function readFile() 
    {
        $file = 'http://external.srch20.com/searchit/xml/jobs';
        $xml = simplexml_load_file($file) or die("Error: Cannot create object");
        $vacancies = $xml->vacancy;
        $jobs = Job::orderBy('job_id', 'desc')->get();

        foreach($vacancies as $job)
        {
            $date = date("Y-m-d H:i:s", strtotime($job->publish_date));
            $slug = $this->slugify( $job->title.'-'.$job->id );
            $salary_min = preg_replace("/\./", "", $job->salary_fixed);
            $salary_max = preg_replace("/\./", "", $job->salary_bonus);

            $jobSingleCatPivot = DB::table('searchit_jobs_job_categories');
            $jobSingleTypePivot = DB::table('searchit_jobs_job_types');

            $jobCategory = $job->categories->category;

            if($this->getJobCount('job_id', $job->id) !== 0)
            {
                if($this->getJobVal('job_id', $job->id, 'date') !== $date)
                {
                    Job::where('job_id', $job->id)->update(
                        [
                            'title'         => $job->title,
                            'summary'       => $job->description,
                            'date'          => $date,
                            'salary_min'    => $salary_min,
                            'salary_max'    => $salary_max,
                            'location'      => $job->address,
                            'lat'           => $job->lat,
                            'lng'           => $job->lng,
                            'slug'          => $slug,
                        ]
                    );
                    $jobSingleRow = Job::where('job_id', $job->id)->first();
                    $jobSingleID = $jobSingleRow->id;

                    foreach($jobCategory as $category)
                    {
                        if($category['group'] == '#2 Skill Area')
                        {
                            if($category == 'Sales' || $category == 'Recruitment')
                            {
                                $cat = 'Recruitment and Sales';
                            } 
                            else 
                            {
                                $cat = $category;
                            }
                            $jobSingleCatRow = Category::where('category_name', $cat)->first();
                            $jobSingleCatID = $jobSingleCatRow->id;
                            $jobSingleCatPivot->insert([ 'job_id' => $jobSingleID, 'category_id' => $jobSingleCatID ]);
                        }
                        if($category['group'] == '#1 Availability')
                        {
                            $type = $category;
                            $jobSingleTypeRow = Type::where('type_name', $type)->first();
                            $jobSingleTypeID = $jobSingleTypeRow->id;
                            $jobSingleTypePivot->insert([ 'job_id' => $jobSingleID, 'type_id' => $jobSingleTypeID ]);
                        }
                    }

                }
            } 
            else 
            {
                Job::insertGetId(
                    [
                        'job_id'        => $job->id,
                        'title'         => $job->title,
                        'summary'       => $job->description,
                        'date'          => $date,
                        'salary_min'    => $salary_min,
                        'salary_max'    => $salary_max,
                        'location'      => $job->address,
                        'lat'           => $job->lat,
                        'lng'           => $job->lng,
                        'slug'          => $slug,
                    ]
                );
                $jobSingleRow = Job::where('job_id', $job->id)->first();
                $jobSingleID = $jobSingleRow->id;

                foreach($jobCategory as $category)
                {
                    if($category['group'] == '#2 Skill Area')
                    {
                        if($category == 'Sales' || $category == 'Recruitment')
                        {
                            $cat = 'Recruitment and Sales';
                        } 
                        else 
                        {
                            $cat = $category;
                        }
                        $jobSingleCatRow = Category::where('category_name', $cat)->first();
                        $jobSingleCatID = $jobSingleCatRow->id;
                        $jobSingleCatPivot->insert([ 'job_id' => $jobSingleID, 'category_id' => $jobSingleCatID ]);
                    }
                    if($category['group'] == '#1 Availability')
                    {
                        $type = $category;
                        $jobSingleTypeRow = Type::where('type_name', $type)->first();
                        $jobSingleTypeID = $jobSingleTypeRow->id;
                        $jobSingleTypePivot->insert([ 'job_id' => $jobSingleID, 'type_id' => $jobSingleTypeID ]);
                    }
                }
            }

        }

    }

    /*
    *
    * Return the number of rows founded
    *
    */
    protected function getJobCount($key, $value)
    {
        return Job::where($key, $value)->count();
    }

    /*
    *
    * Return the value from a table row
    *
    */
    protected function getJobVal($key, $value, $pluck)
    {
        return Job::where($key, $value)->pluck($pluck);
    }

    /*
    *
    * Make valid slug from a string
    *
    */
    protected function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}