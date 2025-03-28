<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model

class AdminController extends Controller
{
    public function viewProducts()
    {
        $products = Product::all(); // Fetch all products from the database
        return view('admin.view-products', compact('products'));
    }
}
