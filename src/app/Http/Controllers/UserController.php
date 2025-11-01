<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class UserController extends Controller
{
    public function update(Request $request) {
        // $profile = Profile::find($id);
        return view('mypage/edit_profile');
    }
}
