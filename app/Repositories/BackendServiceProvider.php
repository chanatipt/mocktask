<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        /* fbsg-signature-createRepositories:<begin> */
        /* fbsg-signature-registerRepository:<begin> task */
        $this->app->bind('App\Repositories\taskRepositoryInterface', 'App\Repositories\taskRepository');
        /* fbsg-signature-registerRepository:<end> task */
        /* fbsg-signature-createRepositories:<end> */
    }
}
