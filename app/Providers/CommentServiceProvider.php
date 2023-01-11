<?php

namespace App\Providers;

use App\Repository\Comment\CommentRepository;
use App\Repository\Comment\CommentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }
}
