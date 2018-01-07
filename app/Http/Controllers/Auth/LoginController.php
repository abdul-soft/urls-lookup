<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FacebookAccountService;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $facebookAccountService;

    /**
     * Create a new controller instance.
     *
     * @param FacebookAccountService $facebookAccountService
     * @return void
     */
    public function __construct(FacebookAccountService $facebookAccountService)
    {
        $this->middleware('guest')->except('logout');
        $this->facebookAccountService   =   $facebookAccountService;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $this->facebookAccountService->getAccountUser($request);

        $user = User::firstOrCreate(['phone' => $data->phone->number ]);

        Auth::loginUsingId($user->id);

        return $this->sendLoginResponse($request);
    }
}
