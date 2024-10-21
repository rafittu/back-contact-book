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

    public function createContact(array $data): array
    {
        // Consultar API ViaCEP
        $addressData = $this->fetchAddressFromCep($data['cep']);

        // Criar o endereço no banco de dados
        $address = $this->addressRepository->create($addressData);

        // Criar o contato associado ao endereço
        $contactData = array_merge($data, ['address_id' => $address->id]);
        $contact = $this->contactRepository->create($contactData);

        // Retornar o contato com o endereço
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
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

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
