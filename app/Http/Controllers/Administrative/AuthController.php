<?php

namespace App\Http\Controllers\Administrative;

use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{

  public function index()
  {
    return view('administrative.login');
  }
  protected function authenticated(Request $request, $user)
  {
    return redirect('/dashboard');
  }

  protected function validateLogin(Request $request)
  {

    $request->validate([
      $this->username() => 'required',
      'password' => 'required',
    ]);
  }

  public function authenticate(Request $request)
  {

    $this->validate($request, [
      'email' => 'email|required', 'password' => 'required',
    ]);
    $credentials = [
      'email' => $request->get('email'),
      'password' => $request->get('password')
    ];
    $result = Auth::attempt($credentials);

    if ($result) {
      return redirect()->route('administrative.dashboard');
    } else {
      $errors = new MessageBag(['password' => ['Email or Password invalid.']]);
      return redirect()->back()->withErrors($errors);
    }
  }
  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }
}
