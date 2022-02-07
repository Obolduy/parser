<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        @auth
            Вы успешно вошли с помощью <a href="@php echo $_ENV['LINKCUTTER_LINK'] @endphp">Linkcutter</a>.
        @endauth

        @guest
            <a href="/login">Войти</a>
        @endguest
    </header>
    <div id="main">
        @yield('main')
    </div>
</body>
</html>