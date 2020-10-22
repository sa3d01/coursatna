<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('dashboard.contacts.index')
            ->with('messages', Contact::where(['seen' => false])->orderBy('id', 'desc')->paginate())
            ->with('total', Contact::where(['seen' => false])->count());
    }
}
