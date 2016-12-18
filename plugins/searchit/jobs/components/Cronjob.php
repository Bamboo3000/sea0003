<?php namespace Searchit\Jobs\Components;

use Cms\Classes\ComponentBase;
use Searchit\Jobs\Models\Job;

class Cronjob extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Cronjob Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun() 
    {
        $this->vacancy = $this->readFile();
    }

    public $vacancy;


    protected function readFile() 
    {
        $file = 'http://external.srch20.com/searchit/xml/jobs';
        $xml = simplexml_load_file($file) or die("Error: Cannot create object");
        $vacancies = $xml->vacancy;

        foreach($vacancies as $job)
        {
            $jobCategory = $job->categories->category;
            foreach($jobCategory as $sCat)
            {
                if($sCat['group'] == '#2 Skill Area')
                {
                    if($sCat == 'Sales' || $sCat == 'Recruitment')
                    {
                        $cat = 'Recruitment and Sales'; 
                    } 
                    else 
                    {
                        $cat = (string)$sCat;
                    }
                    $cats = array('All', $cat);
                    $catsArr = array_map('strtolower', $cats);
                    $category = json_encode($catsArr);
                }
                if($sCat['group'] == '#1 Availability')
                {
                    $type = $sCat;
                }
            }

            $date = date("Y-m-d H:i:s", strtotime($job->publish_date));
            $slug = $this->slugify( $job->title.'-'.$job->id );

            if($this->getJobCount('job_id', $job->id) !== 0)
            {
                if($this->getJobVal('job_id', $job->id, 'date') !== $date)
                {
                    Job::where('job_id', $job->id)
                    ->update([
                        'title'         => $job->title,
                        'summary'       => $job->description,
                        'category'      => $category,
                        'type'          => $type,
                        'date'          => $date,
                        'salary_min'    => $job->salary_fixed,
                        'salary_max'    => $job->salary_bonus,
                        'location'      => $job->address,
                        'lat'           => $job->lat,
                        'lng'           => $job->lng,
                        'slug'          => $slug,
                    ]);
                }
            } 
            else 
            {
                Job::insertGetId(
                    [
                        'job_id'        => $job->id,
                        'title'         => $job->title,
                        'summary'       => $job->description,
                        'category'      => $category,
                        'type'          => $type,
                        'date'          => $date,
                        'salary_min'    => $job->salary_fixed,
                        'salary_max'    => $job->salary_bonus,
                        'location'      => $job->address,
                        'lat'           => $job->lat,
                        'lng'           => $job->lng,
                        'slug'          => $slug,
                    ]
                );
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