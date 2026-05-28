<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    public function create()
    {
        return view('contactar');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:25',
            'message' => 'required|string|min:5',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', '¡Gracias por contactarnos! Tu mensaje ha sido enviado.');
    }
}
