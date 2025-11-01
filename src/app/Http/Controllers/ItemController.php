<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Purchase;

class ItemController extends Controller
{
    public function index (Request $request) {
        $items = Item::all();
        return view('index', compact('items'));
    }
}
