<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);
    
        $category = Category::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);
    
        return redirect()->route('transactions.create')->with('success', 'Category added!');
    }
}
