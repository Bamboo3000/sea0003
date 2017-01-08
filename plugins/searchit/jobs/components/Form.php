<?php namespace Searchit\Jobs\Components;

use Cms\Classes\ComponentBase;
use Searchit\Jobs\Models\Job;

class Form extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Form Component',
            'description' => 'No description provided yet...'
        ];
    }

    /*
    *
    * Return categories column
    *
    */
    protected function onFormSubmit()
    {
        $title = input('job-title');
        $type = input('job-type');
        $location = input('job-location');
        $category = input('job-category');
        $salaryMin = input('job-salary-min');
        $salaryMax = input('job-salary-max');

        if($_FILES["cv-file"]["name"]) {
            $ftp_server = "serv7.mooieserver.nl";
            $ftp_username   = "ejbrecruit";
            $ftp_password   =  "OBQfVGQ?cuh";
            // setup of connection
            $conn_id = ftp_connect($ftp_server) or die("could not connect to the server ;(");

            if($_FILES['cv-file']['size'] < (2097152)) { //can't be larger than 2 MB
                // login
                if (@ftp_login($conn_id, $ftp_username, $ftp_password)) {
                  echo "conectd as current user\n";
                }
                else {
                  echo "could not connect as current user\n";
                }

                $upload_file = $_FILES["cv-file"]["name"];
                $remote_file_path = "/domains/searchitrecruitment.com/public_html/wp-content/themes/searchit/file/" . $upload_file;
                ftp_put($conn_id, $remote_file_path, $_FILES["cv-file"]["tmp_name"], FTP_BINARY);
                ftp_close($conn_id);
                echo "\n\nconnection closed \n\r file upload end with success! :D";
            } else {
                echo 'Oops!  Your file\'s size is to large.';
            }
        }   
        /*
        | -------------------------------------------------------------------
        |   API settings
        | -------------------------------------------------------------------
        */
        $key = 'XoslTEyE';
        $secret = 'ZZXRgDovPQvPfLjklPLBoTAl';
        /*
        | -------------------------------------------------------------------
        |   Example
        | -------------------------------------------------------------------
        */
        if (!function_exists('curl_file_create')) {
            function curl_file_create($filename, $mimetype = '', $postname = '') {
                return "@$filename;filename="
                    . ($postname ?: basename($filename))
                    . ($mimetype ? ";type=$mimetype" : '');
            }
        }

        $endpoint = 'people/add_to_queue';
        $signature = bin2hex(hash_hmac('sha1', $endpoint.'/'.$key, $secret, true));
        // Set up the url
        $uri = "http://api.searchsoftware.nl/{$endpoint}?api_key={$key}&signature={$signature}";

        $application_data = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'note' => array(
                'text' => $_POST['message'],
            ),
            'job' => array(
                'id' => $_POST['job-id'],
            ),
        );

        if($_FILES["cv-file"]["name"]){
            $uploaded_file = realpath(getcwd().'/../file/'.$upload_file);
            $file_cv = curl_file_create($uploaded_file, 'application/pdf', $upload_file);
            $data = array(
                'json' => json_encode($application_data),
                'cv' => $file_cv
            );
        } else {
            $data = array(
                'json' => json_encode($application_data)
            );
        }

        // initialise the curl request
        $request = curl_init();

        curl_setopt($request, CURLOPT_URL, $uri);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_POST, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, $data);

        $reply = curl_exec($request);
        // close the session
        curl_close($request);

        // echo var_dump($file_cv);
        // echo var_dump($reply);

        $newURL = 'https://www.searchitrecruitment.com/form-success-page/';
        header('Location: ' . $newURL);
        die();

        return [
            $this->page['result'] = $this->search
        ];

    }

    /*
    *
    * Return the number of rows founded
    *
    */
    public function getCatCount($value)
    {
        return Job::where('category', 'LIKE', "%{$value}%")->count();
    }

    public $search;

}