@section('title', 'Парсер Brandshop - главная')
@section('main')
<button id="btn__getTable">Получить таблицу со скидками</button>
<script src="{{url('js/ajaxsender.js')}}"></script>
<div id="link__table"></div>
@endsection
@include('layout')