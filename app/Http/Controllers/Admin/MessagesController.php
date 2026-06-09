<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MessagesController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', ['title' => 'Messages']);
    }
}
