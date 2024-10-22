<?php

namespace App\Interfaces;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function create(array $data): Address;
}
