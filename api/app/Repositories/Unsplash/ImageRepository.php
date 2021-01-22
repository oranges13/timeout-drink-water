<?php

namespace App\Repositories\Unsplash;

use App\Contracts\Repositories\ImageRepositoryInterface;
use Unsplash\HttpClient;
use Unsplash\Photo;

class ImageRepository implements ImageRepositoryInterface
{
    /** @var string */
    protected $clientId;

    public function __construct()
    {
        $this->clientId = config('image.providers.unsplash.client_id');
        HttpClient::init([
            'applicationId' => $this->clientId,
            'utmSource'     => env('APP_NAME'),
        ]);
    }

    /**
     * Query for random photo based on provided data.
     *
     * @return array Array with 'url', 'alt', 'color', and 'credit' keys that will be returned to the controller
     */
    public function getRandom()
    {
        $filters = ['query' => 'hydrate', 'orientation' => 'landscape'];
        $photo = Photo::random($filters);

        return [
            'url'    => $photo->urls['raw'].'&',
            'alt'    => $photo->description,
            'color'  => $photo->color,
            'credit' => 'Photo by '.$photo->user['name'].' on '.config('image.providers.unsplash.attribution'),
        ];
    }
}
