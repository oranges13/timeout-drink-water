<?php

use App\Contracts\Repositories\ImageRepositoryInterface;
use Illuminate\Support\Facades\Http;

class ImageRepositoryTest extends TestCase
{
    /**
     * @var ImageRepositoryInterface
     */
    protected $repository;

    public function test_it_will_respond_with_data()
    {
        Http::fake([
            '*' => Http::response([
                'page'     => 1,
                'per_page' => 1,
                'photos'   => [
                    [
                        'photographer' => 'Someone',
                        'avg_color'    => '#cc9900',
                        'src'          => [
                            'original' => 'https://placekitten.com/800/600',
                        ],
                    ],
                ],
                'total_results' => 1,
            ]),
        ]);

        $response = $this->repository->getRandom();

        Http::assertSent(function ($request) {
            return str_starts_with($request->url(), 'https://api.pexels.com/v1/search');
        });

        $this->assertArrayHasKey('url', $response);
        $this->assertArrayHasKey('alt', $response);
        $this->assertArrayHasKey('color', $response);
        $this->assertArrayHasKey('credit', $response);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app()->make(ImageRepositoryInterface::class);
    }
}
