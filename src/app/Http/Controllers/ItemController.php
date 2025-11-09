<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index (Request $request) {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->input('keyword');

        if ($tab === 'recommend') {
            $items = Item::when(auth()->check(), function ($query) {
                $query->where('user_id', '!=', auth()->id());
            })
                ->keywordSearch($keyword)
                ->get();
        } elseif ($tab === 'mylist') {
            if (auth()->check()) {
                $items = auth()->user()
                    ->favorites()
                    ->where('items.user_id', '!=', auth()->id())
                    ->keywordSearch($keyword)
                    ->get();
            } else {
                $items = collect();
            }
        } else {
            $item = Item::keywordSearch($keyword)->get();
        }
        return view('index', compact('items', 'tab', 'keyword'));
    }

    public function show (Item $item) {
        $item->load('favoritedBy');
        return view('item', compact('item'));
    }

    public function create () {
        $categories = Category::all();
        return view('exhibition', compact('categories'));
    }

    public function store (ExhibitionRequest $request) {
        
    }
}
