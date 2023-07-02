<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserProfileController extends Controller
{
    public function show(string $username): RedirectResponse|View
    {
        return view('pages.users.profile.show', [
            'user' => User::whereUsername($username)->first()
        ]);
    }
}
