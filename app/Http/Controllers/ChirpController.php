<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function index()
    {
        $chirps = Chirp::with('user')
        ->latest()
        ->take(50)
        ->get();
        
        return view('home', ['chirps' => $chirps]);
    }

    public function store(Request $request)
    {
        // Validate the request data and provide custom error messages
        $validated = $request->validate([
            'message' => 'required|string|max:255',
         ], [
              'message.required' => 'The message field needs to be filled out.',
              'message.max' => 'Message must be 255 or less characters long.', 
        ]);
        //Izveido jaunu "chirp" ierakstu datubāzē, izmantojot validētos datus
        \App\Models\Chirp::create([

            'message' => $validated['message'],
            'user_id' => null,
        ]);

        // Pāradresē lietotāju atpakaļ uz sākumlapu
        return redirect ('/') -> with('success', 'Chirp created successfully!');
    }
}
