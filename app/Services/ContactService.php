<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Repositories\AddressRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContactService
{
    private ContactRepository $contactRepository;
    private AddressRepository $addressRepository;

    public function __construct(ContactRepository $contactRepository, AddressRepository $addressRepository)
    {
        $this->contactRepository = $contactRepository;
        $this->addressRepository = $addressRepository;
    }

    public function searchContacts(?string $name, ?string $email)
    {
        return $this->contactRepository->search($name, $email);
    }

    public function createContact(array $data): array
    {
        $addressData = $this->fetchAddressFromCep($data['cep']);

        $address = $this->addressRepository->create($addressData);

        $contactData = array_merge($data, ['address_id' => $address->id]);
        $contact = $this->contactRepository->create($contactData);

        return [
            'id' => $contact->id,
            'name' => $contact->name,
            'phone' => $contact->phone,
            'email' => $contact->email,
            'address' => $address,
            'created_at' => $contact->created_at,
            'updated_at' => $contact->updated_at
        ];
    }

    private function fetchAddressFromCep(string $cep): array
    {
        $apiUrl = env('VIACEP_URL', 'https://viacep.com.br/ws');
        $response = Http::get("{$apiUrl}/{$cep}/json/");

        if ($response->failed() || isset($response['erro'])) {
            throw ValidationException::withMessages(['cep' => 'CEP inválido ou não encontrado']);
        }

        return [
            'cep' => $response['cep'],
            'street' => $response['logradouro'],
            'neighborhood' => $response['bairro'],
            'city' => $response['localidade'],
            'state' => $response['uf']
        ];
    }
}
