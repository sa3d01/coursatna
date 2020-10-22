<?php

namespace App\Providers;

use App\Models\Item;
use App\Observers\AttachmentObserver;
use Illuminate\Support\ServiceProvider;

class ItemModelProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Item::observe(AttachmentObserver::class);
    }
}
