<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendUserEmailTemplates;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersEmailTemplatesController extends Controller
{
    public function sendEmail(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (User::find($key)) {
                $user = User::where('id', $key)->first();
                $userEmail = $user->email;
                foreach ($value as $item) {
                    if (EmailTemplate::find($item)) {
                        Mail::to($userEmail)->send(new SendUserEmailTemplates($item));
                    }else {
                        return response()->json(["message" => "template with id $item does not exist"]);
                    }
                }
                $user->emailTemplates()->attach($value);
            }else {
                return response()->json(["message" => "this user does not exist"]);
            }
        }
    }
}
