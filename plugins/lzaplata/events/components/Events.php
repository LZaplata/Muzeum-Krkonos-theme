<?php namespace LZaplata\Events\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Events Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Events extends ComponentBase
{
    public function componentDetails()
    {
        return [
            "name"          => "lzaplata.events::lang.component.events.name",
            "description"   => "lzaplata.events::lang.component.events.description",
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {

        return [
            "page" => [
                "title"         => "lzaplata.events::lang.component.events.page.title",
                "description"   => "lzaplata.events::lang.component.events.page.description",
                "type"          => "string",
                "default"       => "{{ :page }}",
            ],
            "perPage" => [
                "title"             => "lzaplata.events::lang.component.events.per_page.title",
                "type"              => "string",
                "validationPattern" => "^[0-9]+$",
                "validationMessage" => "lzaplata.events::lang.component.events.per_page.validation_message",
                'default'           => "10",
            ],
            "eventPage" => [
                "title"         => "lzaplata.events::lang.component.events.event_page.title",
                "description"   => "lzaplata.events::lang.component.events.event_page.description",
                "type"          => "dropdown",
            ],
            "place" => [
                "title"         => "lzaplata.events::lang.component.events.place.title",
                "description"   => "lzaplata.events::lang.component.events.place.description",
                "type"          => "set",
            ],
        ];
    }

    /**
     * @return array
     */
    public function getEventPageOptions(): array
    {
        return Page::sortBy("baseFileName")->lists("baseFileName", "baseFileName");
    }

    /**
     * @return array
     */
    public function getPlaceOptions(): array
    {
        $placeOptions = [];
        $client = new Client();

        try {
            $response = $client->get("https://api.krnap.cz/akce/places/");

            if ($response->getStatusCode() == 200) {
                $places = json_decode($response->getBody()->getContents());

                foreach ($places as $place) {
                    $placeOptions["id_" . $place->placeId] = $place->placeName;
                }
            }
        } catch (GuzzleException $e) {
            Log::error("Error while reading KRNAP API: " . $e->getMessage());
        }

        return $placeOptions;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        $client = new Client();

        try {
            $places = $this->property("place");

            if ($places) {
                foreach ($places as $key => $place) {
                    $places[$key] = str_replace("id_", "", $place);
                }
            }

            $response = $client->get("https://api.krnap.cz/akce/akce?sortBy=date&perPage=" . $this->property("perPage") . "&page=" . $this->property("page") . "&places=" . implode(",", $places));

            if ($response->getStatusCode() == 200) {
                $events = json_decode($response->getBody()->getContents());

                foreach ($events->akce as $key => $event) {
                    $events->akce[$key]->url = $this->controller->pageUrl($this->property("eventPage"), [
                        "id"    => $event->idAkce,
                        "slug"  => str_slug($event->nazevAkce),
                    ]);
                }

                return $events->akce;
            }
        } catch (GuzzleException $e) {
            Log::error("Error while reading KRNAP API: " . $e->getMessage());
        }

        return [];
    }
}
