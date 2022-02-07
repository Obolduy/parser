<?php

namespace App\Http\Controllers;

use App\Models\LinkcutterTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkCutterLoginController extends Controller
{
    public function loginViaApi(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('login');
        }

        $email = htmlspecialchars(strip_tags(trim($request->email)));
        $password = htmlspecialchars(strip_tags(trim($request->password)));

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
            return 'Неправильный Email или пароль'; // Это в метод для аякса перенеси
        }

        $user = LinkcutterTokens::firstOrCreate([
            'token' => $token['token'],
            'setting_date' => now()
        ]);

        session(['linkcutter_token' => $token['token']]);

        Auth::login($user);
        
        $request->session()->regenerate();
        session(['linkcutter_token' => $token['token']]);

        return redirect('/');

    }
}