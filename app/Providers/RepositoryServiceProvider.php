<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ContactRepositoryInterface;
use App\Repositories\ContactRepository;
use App\Interfaces\AddressRepositoryInterface;
use App\Repositories\AddressRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
    }
}
