<?php

use Illuminate\Support\Facades\Http;

class ImageControllerTest extends TestCase
{

    public function test_it_will_respond_with_image_data()
    {
        $this->json('GET', "/800/600")->seeJsonStructure(['url','credit','alt','color']);
    }

    public function test_it_will_throttle_requests()
    {
        $i = 0;
        do {
            $response = $this->call('GET', '/800/600');
            $i++;
        } while ( $response->status() == 200 );

        $this->assertEquals(429, $response->status());
        $this->assertEquals(21, $i);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            '*' => Http::response([
                'page' => 1,
                'per_page' => 1,
                'photos' => [
                    [
                        'photographer' => 'Someone',
                        'avg_color' => '#cc9900',
                        'src' => [
                            'original' => 'https://placekitten.com/800/600',
                        ],
                    ],
                ],
                'total_results' => 1,
            ])
        ]);
    }

}
