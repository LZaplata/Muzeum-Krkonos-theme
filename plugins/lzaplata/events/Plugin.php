<?php namespace LZaplata\Events;

use LZaplata\Events\Components\Event;
use LZaplata\Events\Components\Events;
use System\Classes\PluginBase;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            Events::class   => "events",
            Event::class    => "event",
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }
}
