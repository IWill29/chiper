<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $credentails = $request->validate([
         'email' => 'required|email',
         'password' => 'required',
      ]);

      if (Auth::attempt($credentails, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'Login successful. Welcome back!');
      }

      return back()
        ->withErrors(['email' => 'The provided credentials do not match our records.'])
        ->onlyInput('email');
    }

}
