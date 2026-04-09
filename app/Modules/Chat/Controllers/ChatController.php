<?php

namespace App\Modules\Chat\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index() 
    {
        return view('Chat::app');
    }

    public function getAuth() 
    {
       return $this->sendResponse(Auth::user(), 'Token OK');
    }
}
