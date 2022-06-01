<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailTemplates\StoreEmailTemplatesRequest;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplatesController extends Controller
{

    public function sendEmail(StoreEmailTemplatesRequest $request)
    {
        $validated = $request->validated();
        $email_template = EmailTemplate::create($validated);
        return response()->json(['email_template' => $email_template]);
    }
}
