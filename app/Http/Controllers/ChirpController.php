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

        auth()->user()->chirps()->create($validated);

        // Pāradresē lietotāju atpakaļ uz sākumlapu
        return redirect ('/') -> with('success', 'Chirp created successfully!');
    }


    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        
        return view('chirps.edit',compact('chirp'));
    }

    public function update(Request $request, Chirp $chirp)
    {   
        if ($request->user()->cannot('update', $chirp)) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp updated successfully!');

    }

    public function destroy(Chirp $chirp)
    {
        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted successfully!');
    }
}
