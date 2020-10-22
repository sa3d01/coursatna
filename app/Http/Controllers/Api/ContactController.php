<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ContactStoreRequest;
use App\Http\Controllers\Controller;
use App\Models\Contact as ContactModel;

class ContactController extends Controller
{
    public function store(ContactStoreRequest $request)
    {
        $data = $request->validated();
        $data['seen'] = false;
        ContactModel::create($data);
        return response()->json(['message' => 'شكراً لرسالتك، هنتواصل معاك قريب'], 201);
    }
}
