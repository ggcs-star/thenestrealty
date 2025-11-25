<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DocumentController extends Controller
{

    public function index(Request $request): View
    {
        return view('document.generate', [
            'user' => $request->user(),
        ]);
    }
    public function template()
    {
        return view('document.template');
    }
}
