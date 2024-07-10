<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index()
{
    $products = Product::all();
    return view('your_view_name', ['data' => $products]);
}
    public function create()
    {
        return view('purchase.create');
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'locality' => 'nullable|string|max:255',
        ]);
    
        // Save data to the database
        Purchase::create($validatedData);
    
        // Optionally, redirect back or show a success message
        return redirect()->back()->with('success', 'Order placed successfully!');
    }
    
}
