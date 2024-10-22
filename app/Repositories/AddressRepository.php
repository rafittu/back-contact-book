<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    public function create(array $data): Address
    {
        return Address::create($data);
    }
}
