<?php namespace LZaplata\Availability;

use Backend;
use LZaplata\Availability\Components\Widget;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Availability',
            'description' => 'No description provided yet...',
            'author' => 'LZaplata',
        ];
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            Widget::class => "widget",
        ];
    }
}
