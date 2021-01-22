<?php


namespace App\Repositories\Pexels;


use App\Contracts\Repositories\ImageRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ImageRepository implements ImageRepositoryInterface
{

    /** @var string */
    protected $client_id;

    /** @var string */
    protected $base_url;

    public function __construct()
    {
        $this->client_id = config('image.providers.pexels.client_id');
        $this->base_url = config('image.providers.pexels.base_url');
    }

    /**
     * Query for random photo based on provided data
     * @return array Array with 'url', 'alt', 'color', and 'credit' keys that will be returned to the controller
     */
    public function getRandom()
    {
        $photo = Cache::remember('pexels_random', 300, function() {
            // Get initial query of photos
            $response = Http::withHeaders([
                'Authorization' => $this->client_id,
            ])->get($this->base_url . '/search', [
                'query' => 'hydrate',
                'orientation' => 'landscape',
                'size' => 'medium',
            ])->throw();

            $photos = collect($response->json());
            $total_results = $photos['total_results'];
            $per_page = $photos['per_page'] ?? 15;
            $total_pages = floor($total_results/$per_page);

            // Grab a random page from the result set
            $get_page = rand(1, $total_pages);
            $get_photo = rand(0, $per_page - 1);

            if ($get_page == 1) {
                return $photos['photos'][$get_photo];
            } else {
                // Grab a random page and return the random photo
                $randomPhoto = Http::withHeaders([
                    'Authorization' => $this->client_id,
                ])->get($this->base_url . '/search', [
                    'query' => 'hydration',
                    'orientation' => 'landscape',
                    'size' => 'medium',
                    'page' => $get_page,
                ])->throw();

                return $randomPhoto['photos'][$get_photo];
            }
        });

        return [
            'url' => $photo['src']['original'] . "?",
            'alt' => $photo['photographer'],
            'color' => $photo['avg_color'],
            'credit' => 'Photo by ' . $photo['photographer'] . ' on ' . config('image.providers.pexels.attribution'),
        ];
    }

}
