<?php

namespace App\Http\Controllers;

use App\Models\LinkcutterTokens;
use Illuminate\Http\Request;

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

        if ($token[0] === 'error') {
            return 'Неправильный Email или пароль'; // Это в метод для аякса перенеси
        }

        LinkcutterTokens::create([
            'token' => $token[1],
            'setting_date' => now()->date
        ]);

        $_SESSION['token'] = $token[1];

        return redirect('/');
    }
}