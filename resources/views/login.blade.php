@section('title', 'Парсер Brandshop - Вход')
@section('main')
<div class="login__text">
    Если у вас есть аккаунт на сайте <a href="@php echo $_ENV['LINKCUTTER_LINK'] @endphp">Linkcutter</a>, Вы можете воспользоваться им для входа и создания сокращенных ссылок. 
</div>
<div id="login__error"></div>
<div class="login__form">
    <form method="post">
        @csrf
        <div class="login__form">Введите Email: <input type="text" name="email" id="login__email"></div>
        <div class="login__form">Введите пароль: <input type="password" name="password" id="login__password"></div>
        <div class="login__form"><input type="submit" value="Войти" id="submit"></div>
    </form>
</div>
<script src="{{url('js/loginchecker.js')}}"></script>
@endsection
@include('layout')