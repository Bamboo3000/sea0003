<?php namespace Searchit\Jobs\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'searchit_jobs_categories';

    public $belongsToMany = [

        'jobs' => [
            'Searchit\Jobs\Models\Job',
            'table' => 'searchit_jobs_job_categories',
            'order' => 'title'
        ]

    ];

}