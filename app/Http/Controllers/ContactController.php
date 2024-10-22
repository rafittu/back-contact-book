<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    private ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function store(CreateContactRequest $request): JsonResponse
    {
        $contact = $this->contactService->createContact($request->validated());
        return response()->json($contact, 201);
    }

    public function index(Request $request): JsonResponse
    {
        $name = $request->query('name');
        $email = $request->query('email');

        $contacts = $this->contactService->searchContacts($name, $email);

        return response()->json($contacts, 200);
    }
}
