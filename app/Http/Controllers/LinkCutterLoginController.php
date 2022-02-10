<?php

namespace App\Http\Controllers;

use App\Models\LinkcutterTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkCutterLoginController extends Controller
{
    /**
     * Takes form data from AJAX and sends request to linkcutter service about user.
     * @param Request $request
     * @return string JSON ok/error-status
     */

    public function checkLogin(Request $request): string
    {
        $data = json_decode($request->getContent());

        $email = htmlspecialchars(strip_tags(trim($data->email)));
        $password = htmlspecialchars(strip_tags(trim($data->password)));

        $curl = CurlController::sendCurlRequest(
            [
                CURLOPT_URL => $_ENV['LINKCUTTER_LINK'].'/api/registration',
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'email' => $email,
                    'password' => $password
                ]
            ]
        );

        $token = json_decode($curl, true);

        if (array_key_exists('error', $token)) {
            return json_encode(['error' => 'Неправильный Email или пароль'], JSON_UNESCAPED_UNICODE);
        }

        return $this->loginViaApi($request, $token['token']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Sets linkcutter token and authorizates user.
     * @param Request $request
     * @param string $token auth token
     * @return string JSON ok-status
     */

    private function loginViaApi(Request $request, string $token): string
    {
        $user = LinkcutterTokens::firstOrCreate([
            'token' => $token,
            'setting_date' => now()
        ]);

        session(['linkcutter_token' => $token]);

        Auth::login($user);
        
        $request->session()->regenerate();
        session(['linkcutter_token' => $token]);

        return json_encode(['ok' => 'ok'], JSON_UNESCAPED_UNICODE);
    }
}