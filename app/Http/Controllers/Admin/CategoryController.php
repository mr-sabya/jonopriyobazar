<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display the main Category Management page.
     * 
     * Since we are using a single Livewire component, 
     * we only need one method to return the base view.
     */
    public function index()
    {
        $authUser = Admin::find(Auth::user()->id);
        // Permission check using standard Laravel Auth
        if (!$authUser->can('category.index')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backend.category.index');
    }
}