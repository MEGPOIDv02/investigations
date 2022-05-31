<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\GenericResponse;
use App\Models\PasswordReset;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = RouteServiceProvider::HOME_ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function authenticate(LoginRequest $request)
    {
        $remember = true;

        $loginParams = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'active' => 1
        ];


        $emailLogin = $request->input('email');
        $userActive = User::where('email', $emailLogin)->first();
        if ($userActive->active == 1) {
            if (Auth::guard('admin')->attempt($loginParams, $remember)) {
                if ($userActive->fk_id_role == User::ADMIN) {
                    return redirect()->route('admin.vue', 'users');
                } else {
                    return redirect()->route('admin.vue', 'accelometer');
                }
            } else {
                Auth::logout();
                $request->session()->flush();
                $request->session()->regenerate();
                return redirect()
                    ->route('admin.login')
                    ->with('emailFail', 'El correo o contraseña son incorrectos');
            }
        } else {
            Auth::logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()
                ->route('admin.login')
                ->with('emailInactive', 'El correo no esta activo');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('admin.login');
    }

    /**
     * @return mixed
     */
    public function recoveryPassword()
    {
        return view('admin.auth.recovery_password');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function redirectResetPassword(Request $request)
    {
        $token = $request->get('token', null);
        $userToken = PasswordReset::where('token', $token)->first();

        if ($userToken) {
            return view('admin.auth.reset_password')->with(['token' => $token]);
        } else {
            return redirect()->route('admin.login')->with('resetError', 'El token para recuperar su contraseña ha expirado');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changePassword(Request $request)
    {

        $token = $request->input('token');
        $reset = PasswordReset::where('token', $token)->first();
        $password = $request->input('password');
        $password_confirm = $request->get('password-confirm');

        if ($reset) {
            if ($password === $password_confirm) {
                $user = User::where('email', $reset->email)->first();
                $user->password = bcrypt($request->get('password'));
                $user->save();
                return redirect()->route('admin.login')->with('resetSuccess', 'Su contraseña ha sido reestablecida con éxito.');
            } else {
                return redirect()->back()->with('resetError', 'Las contraseñas que ingreso no coinciden, por favor vuelva a intentarlo.');
            }
        }
        return redirect()->route('admin.login')->with('resetError', 'El token para recuperar su contraseña ha expirado');
    }


    /**
     * @param PasswordRecoveryRequest $request
     * @return mixed
     */
    public function passwordRecoveryPost(Request $request)
    {
        $email = $request->input('email', null);
        $response = new GenericResponse();

        $client = User::whereEmail($email)->first();
        $token = bcrypt(Carbon::now()->toDateTimeString());

        if ($client == null) {
            return redirect()->route('admin.login')->with("error", "El correo que usted ingreso no esta registrado como administrador. Por favor verifique y vuelva a intentarlo.");
        } else {
            $reset = new PasswordReset();
            $reset->email = $client->email;
            $reset->token = $token;
            $reset->created_at = date('Y-m-d H:i:s', strtotime('+1 hours'));
            if ($reset->save()) {
                if ($this->passwordRequestEmail($client->email, $token)) {
                    $response->success = true;
                    return redirect()->route('admin.login')->with("success", "Te enviamos un correo con el enlace para recuperar tu contraseña.");
                } else {
                    $response->success = false;
                    return redirect()->route('admin.login')->with("errorMail", "Ocurrio un problema al enviar el correo, por favor vuelva a intentar mas tarde.");
                }
            } else {
                return redirect()->route('admin.login')->with("errorMail", "Ocurrio un problema al enviar el correo, por favor vuelva a intentar mas tarde.");
            }
        }
    }

    /**
     * @param $email
     * @param $token
     * @return mixed
     */
    private function passwordRequestEmail($email, $token)
    {
        try {
            Mail::send(
                'emails.reset_password_email',
                ['token' => $token],
                function ($msj) use ($email) {
                    $msj->subject('GRHN | Recuperar contraseña');
                    $msj->to($email);
                    $msj->setFrom('GRHN@satoritech.com.mx', 'GRHN');
                });
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
