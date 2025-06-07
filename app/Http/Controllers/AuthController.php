<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
  public function loadRegister()
  {
      if(Auth::user()){
        $route = $this->redirectDa();
        return redirect($route);
      }
      return view('register');
  } 
  public function register(Request $req)
  {
    $req->validate([
       'name' => 'required',
       'email' => 'email|required',
       'password' => 'required|confirmed',
    ],[
      'name.required' => 'Name is required',
      'email.required' => 'Email is required',
      'password.required' => 'Password is required',
    ]);
    $user = new User;
    $user->name = $req->name;
    $user->email = $req->email;
    $user->password = Hash::make($req->password);
    $user->save();
    return redirect()->route('register')->with('success','Thankyou for registration');
  }
  public function redirectDa()
  {
    $redirect = '';
    if(Auth::user() && Auth::user()->role_id == 1){
        $redirect = '/admin/dashboard';
    }
    else
    {
        $redirect = '/';
    }
    return $redirect;
  }
  public function loadLogin()
  {
    if(Auth::user()){
        $route = $this->redirectDa();
        return redirect($route);
    }
    return view('login');
  }
  public function login(Request $req)
  {
    $req->validate([
      'email' => 'string|required|email',
      'password' => 'string|required',
    ],[
      'email.required' => 'Email is required',
      'password.required' => 'Password is required',
    ]);
    $email = $req->input('email');
    $password = $req->input('password');
    $userEmail = User::where('email', $email)->first();

          if (Auth::attempt(['email' => $email, 'password' => $password])){
              // Retrieve the authenticated user
              $route = $this->redirectDa();
              return redirect($route);
            }
          else if(!$userEmail){
            return redirect()->back()->withInput()->withErrors([
                'email' => 'Email address is incorrect',
            ]);
          }
          else{
            return redirect()->back()->withInput()->withErrors([
                'password' => 'Password is incorrect',
            ]);
          }
  }
  public function loadDashboard()
  {
    return view('user.dashboard');
  }
  public function logout(Request $req)
  {
     $req->session()->flush();
     Auth::logout();
     return redirect('/');
  }
}
