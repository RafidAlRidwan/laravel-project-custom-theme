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
  public function adminIndex()
  {
    return view('administrative.dashboard');
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
      'employee_id' => 'required', 'password' => 'required',
    ]);
    $credentials = [
      'employee_id' => $request->get('employee_id'),
      'password' => $request->get('password')
    ];
    dd(Auth::attempt($credentials));
    $result = Auth::attempt($credentials);

    if ($result) {
      $user = $request->user();
      return redirect()->route('administrative.dashboard');
    } else {
      $errors = new MessageBag(['password' => ['Employee ID and/or Password invalid.']]);
      return redirect()->back()->withErrors($errors);
    }
  }
  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }
}
