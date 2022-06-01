<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendUserEmailTemplates;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersEmailTemplatesController extends Controller
{
    public function sendEmail(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $user = User::where('id', $key)->first();
            $userEmail = $user->email;
            foreach ($value as $item) {
                Mail::to($userEmail)->send(new SendUserEmailTemplates($item));
            }
            $user->emailTemplates()->attach($value);
        }
    }
}
