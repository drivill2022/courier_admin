<?php
namespace App\Http\Controllers\Merchant\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
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
    public $redirectTo = '/merchant/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('merchant.guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('merchant.auth.login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'mobile'   => 'required',
        'password' => 'required'
      ]);
      // Attempt to log the user in
      if (Auth::guard('merchant')->attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('merchant.dashboard'));
      } 
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('mobile','password', 'remember'))->with('flash_error','Mobile or password are incorrect!');
    }
    
    public function logout()
    {
        Auth::guard('merchant')->logout();
        return redirect('/merchant');
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('merchant');
    }
}
