<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::created(function($user) {
            Mail::to($user)->send(new UserCreated($user));
        });

        
        Product::updated(function($product) {
            if($product->quantity == 0 && $product->isAvailable())
            {
                $product->status = Product::UNAVAILABLE_PRODUCT;

                $product->save();
            }
        });
    }
}
