@section('title', 'Парсер Brandshop - Вход')
@section('main')
<div class="login__text">
    Если у вас есть аккаунт на сайте <a href="@php echo $_ENV['LINKCUTTER_LINK'] @endphp">Linkcutter</a>, Вы можете воспользоваться им для входа и создания сокращенных ссылок. 
</div>
<div class="login__form">
    <form method="post">
        @csrf
        <div class="login__form">Введите Email: <input type="text" name="email"></div>
        <div class="login__form">Введите пароль: <input type="password" name="password"></div>
        <div class="login__form"><input type="submit" value="Войти"></div>
    </form>
</div>
@endsection
@include('layout')