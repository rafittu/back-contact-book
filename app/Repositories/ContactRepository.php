<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    public function search(?string $name, ?string $email)
    {
        $query = Contact::query();

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($email) {
            $query->where('email', 'like', "%{$email}%");
        }

        return $query->with('address')->paginate(10);
    }

    public function create(array $data): Contact
    {
        return Contact::create($data);
    }
}
