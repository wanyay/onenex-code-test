<?php

namespace App\Providers;

use App\Repository\Movie\MovieRepository;
use App\Repository\Movie\MovieRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }
}
