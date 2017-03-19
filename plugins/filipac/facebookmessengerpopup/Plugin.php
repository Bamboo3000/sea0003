<?php namespace Filipac\FacebookMessengerPopup;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {

    }

    public function registerComponents()
    {
        return [
            'Filipac\FacebookMessengerPopup\Components\Popup' => 'facebookMessenger'
        ];
    }

}
