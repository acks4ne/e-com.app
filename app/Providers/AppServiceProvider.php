<?php

namespace App\Providers;

use App\Repositories\Instances\CartProductRepository;
use App\Repositories\Instances\CartRepository;
use App\Repositories\Instances\OrderRepository;
use App\Repositories\Instances\OrderStatusRepository;
use App\Repositories\Instances\PaymentMethodRepository;
use App\Repositories\Instances\ProductRepository;
use App\Repositories\Instances\UserRepository;
use App\Repositories\Interfaces\CartProductRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $bindings = [
        CartProductRepositoryInterface::class => CartProductRepository::class,
        CartRepositoryInterface::class => CartRepository::class,
        OrderRepositoryInterface::class => OrderRepository::class,
        OrderStatusRepositoryInterface::class => OrderStatusRepository::class,
        PaymentMethodRepositoryInterface::class => PaymentMethodRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isLocal()) {
            Model::shouldBeStrict();
        }
    }
}
