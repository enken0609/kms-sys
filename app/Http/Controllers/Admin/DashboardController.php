<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Race;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $races = Race::latest()->take(5)->get();
        $categories = Category::withCount('results')->take(5)->get();
        
        return view('admin.dashboard', compact('races', 'categories'));
    }
} 