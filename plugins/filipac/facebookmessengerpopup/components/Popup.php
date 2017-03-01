<?php namespace Filipac\FacebookMessengerPopup\Components;

use Cms\Classes\ComponentBase;
use October\Rain\Network\Http;

class Popup extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Display contact button',
            'description' => 'This adds the button in your page, on the right side.'
        ];
    }

    public function onRun()
    {
        $this->addJs('/plugins/filipac/facebookmessengerpopup/assets/js/index.js');
        $this->addCss('/plugins/filipac/facebookmessengerpopup/assets/css/style.css');
    }

    public function page()
    {
        return $this->property('page');
    }

    public function language()
    {
        return $this->property('language');
    }

    public function defineProperties()
    {
        return [
            'page' => [
                'title'       => 'Facebook Page',
                'type'        => 'text',
                'default'     => '',
                'required'    => true,
                'validationMessage' => 'Please enter your page url.'
            ],
            'language' => [
                'title'       => 'Language',
                'type'        => 'dropdown',
                'default'     => 'en_US',
                'required'    => true,
                'validationMessage' => 'Please enter your language.'
            ],
        ];
    }

    public function getLanguageOptions()
    {
        $test = Http::get('https://www.facebook.com/translations/FacebookLocales.xml');
        $resp = simplexml_load_string($test->body);
        $data = json_decode( json_encode($resp) , 1);
        $ret = [];
        foreach($data['locale'] as $d) {
            $ret[$d['codes']['code']['standard']['representation']] = $d['englishName'];
        }
        return $ret;
    }

}