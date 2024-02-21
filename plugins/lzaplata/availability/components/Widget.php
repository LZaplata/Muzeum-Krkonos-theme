<?php namespace LZaplata\Availability\Components;

use Cms\Classes\ComponentBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Widget Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Widget extends ComponentBase
{
    /**
     * @return array
     */
    public function componentDetails(): array
    {
        return [
            "name"          => "Widget",
            "description"   => "Widget for display availability",
        ];
    }

    /**
     * @return \stdClass
     */
    public function availability(): \stdClass
    {
        $client = new Client();

        try {
            $response = $client->get("https://api.krnap.cz/mk/obsazenost");

            if ($response->getStatusCode() == 200) {
                $availability = json_decode($response->getBody()->getContents());

                return $availability->obsazenost;
            }
        } catch (GuzzleException $e) {
            Log::error("Error while reading KRNAP API: " . $e->getMessage());
        }

        return new \stdClass();
    }
}
