<?php


namespace App\Providers;


use App\Contracts\Repositories\ImageRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImageRepositoryInterface::class, function($app) {
            return $this->resolveRepositoryInterface('ImageRepository');
        });
    }

    public function provides()
    {
        return [
            ImageRepositoryInterface::class,
        ];
    }

    /**
     * Returns an instance of the repository resolved for the selected provider (or default)
     *
     * @param string $repositoryType
     * @return  ImageRepositoryInterface
     */
    protected function resolveRepositoryInterface(string $repositoryType)
    {
        $provider = config('image.default_provider');

        // e.g. App\Repositories\Pexels\ImageRepository
        $repositoryClass = "App\\Repositories\\" . ucwords($provider) . "\\{$repositoryType}";

        return new $repositoryClass();
    }
}
