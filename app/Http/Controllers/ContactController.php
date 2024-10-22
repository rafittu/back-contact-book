<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Services\ContactService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\NotFoundHttpException;

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

    public function destroy(int $id): JsonResponse
    {
        $contact = $this->contactService->deleteContact($id);

        if (!$contact) {
        throw new NotFoundHttpException('Contact not found');
        }

        return response()->json(['message' => 'Contato deletado com sucesso'], 200);
    }
}
