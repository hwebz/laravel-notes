<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Author;

class AdminController extends Controller
{
    public function getLogin() {
    	return view('admin.login');
    }

    public function getDashboard() {
    	// if (!Auth::check()) {
    	// 	return redirect()->back();
    	// } // use middleware in route instead
    	$authors = Author::all();
    	return view('admin.dashboard', compact('authors'));
    }

    public function postLogin(Request $request) { // config Auth at config\auth.php
    	$this->validate($request, [
    		'name' => 'required',
    		'password' => 'required'
    	]);

    	if (!Auth::attempt(['name' => $request['name'], 'password' => $request['password']])) {
    		return redirect()->back()->with('fail', 'Could not log you in!');
    	}
    	return redirect()->route('dashboard');
    }

    public function getLogout() {
    	Auth::logout();
    	return redirect()->route('index');
    }
}
