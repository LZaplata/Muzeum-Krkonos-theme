<?php namespace LZaplata\Events\Components;

use Cms\Classes\ComponentBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Event Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Event extends ComponentBase
{
    public function componentDetails()
    {
        return [
            "name"          => "lzaplata.events::lang.component.event.name",
            "description"   => "lzaplata.events::lang.component.event.description",
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [
            "id" => [
                "title"       => "lzaplata.events::lang.component.event.id.title",
                "description" => "lzaplata.events::lang.component.event.id.description",
                "default"     => "{{ :id }}",
                "type"        => "string",
            ],
        ];
    }

    /**
     * @return \stdClass|bool
     */
    public function event(): \stdClass|bool
    {
        $client = new Client();

        try {
            $response = $client->get("https://api.krnap.cz/akce/detail/" . $this->property("id"));

            if ($response->getStatusCode() == 200) {
                $event = json_decode($response->getBody()->getContents());

                return $event;
            }
        } catch (GuzzleException $e) {
            Log::error("Error while reading KRNAP API: " . $e->getMessage());
        }

        return false;
    }
}
