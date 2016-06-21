@extends('layout')
<?php
$cats_arr = [
    ['title' => 'Астрономия и космонавтика', 'count' => rand(10, 100)],
    ['title' => 'Банковское, биржевое дело и страхование', 'count' => rand(10, 100)],
    ['title' => 'Безопасность жизнедеятельности и охрана труда', 'count' => rand(10, 100)],
    ['title' => 'Биология и естествознание', 'count' => rand(10, 100)],
    ['title' => 'Бухгалтерский учет и аудит', 'count' => rand(10, 100)],
    ['title' => 'Военное дело и гражданская оборона', 'count' => rand(10, 100)],
    ['title' => 'География и экономическая география', 'count' => rand(10, 100)],
    ['title' => 'Геология, гидрология и геодезия', 'count' => rand(10, 100)],
    ['title' => 'Государство и право', 'count' => rand(10, 100)],
    ['title' => 'Журналистика, издательское дело и СМИ', 'count' => rand(10, 100)],
    ['title' => 'Иностранные языки и языкознание', 'count' => rand(10, 100)],
    ['title' => 'История и исторические личности', 'count' => rand(10, 100)],
    ['title' => 'Коммуникации, связь, цифровые приборы и радиоэлектроника', 'count' => rand(10, 100)],
    ['title' => 'Краеведение и этнография', 'count' => rand(10, 100)],
    ['title' => 'Кулинария и продукты питания', 'count' => rand(10, 100)],
    ['title' => 'Культура и искусство', 'count' => rand(10, 100)],
    ['title' => 'Литература', 'count' => rand(10, 100)],
    ['title' => 'Маркетинг, реклама и торговля', 'count' => rand(10, 100)],
    ['title' => 'Математика', 'count' => rand(10, 100)],
    ['title' => 'Медицина', 'count' => rand(10, 100)],
    ['title' => 'Международные отношения и мировая экономика', 'count' => rand(10, 100)],
    ['title' => 'Менеджмент и трудовые отношения', 'count' => rand(10, 100)],
    ['title' => 'Музыка', 'count' => rand(10, 100)],
    ['title' => 'Педагогика', 'count' => rand(10, 100)],
    ['title' => 'Политология', 'count' => rand(10, 100)],
    ['title' => 'Программирование, компьютеры и кибернетика', 'count' => rand(10, 100)],
    ['title' => 'Производство и технологии', 'count' => rand(10, 100)],
    ['title' => 'Психология', 'count' => rand(10, 100)],
    ['title' => 'Разное', 'count' => rand(10, 100)],
    ['title' => 'Религия и мифология', 'count' => rand(10, 100)],
    ['title' => 'Сельское, лесное хозяйство и землепользование', 'count' => rand(10, 100)],
    ['title' => 'Социология и обществознание', 'count' => rand(10, 100)],
    ['title' => 'Спорт и туризм', 'count' => rand(10, 100)],
    ['title' => 'Строительство и архитектура', 'count' => rand(10, 100)],
    ['title' => 'Таможенная система', 'count' => rand(10, 100)],
    ['title' => 'Транспорт', 'count' => rand(10, 100)],
    ['title' => 'Физика и энергетика', 'count' => rand(10, 100)],
    ['title' => 'Философия', 'count' => rand(10, 100)],
    ['title' => 'Финансы, деньги и налоги', 'count' => rand(10, 100)],
    ['title' => 'Химия', 'count' => rand(10, 100)],
    ['title' => 'Экология и охрана природы', 'count' => rand(10, 100)],
    ['title' => 'Экономика и экономическая теория', 'count' => rand(10, 100)],
    ['title' => 'Экономико-математическое моделирование', 'count' => rand(10, 100)],
    ['title' => 'Этика и эстетика', 'count' => rand(10, 100)],
];
?>
@section('content')
<div class="row">
    <div class="col-lg-12">
        <hr>
    </div>
    <div class="col-lg-12">
        <div class="input-group">
            <input id="input-search-query" class="form-control input-lg" type="text" placeholder="введите запрос для поиска">
            <span class="input-group-btn">
                <button class="btn btn-default btn-lg" type="button" title="Поиск" onclick="call({url: '/search', data: {q: $('#input-search-query').val()}});">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
{{--    <div class="col-lg-12">
        <div style="margin: 15px 0; padding: 10px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
        <a href="#" class="btn btn-primary btn-lg">Титульный лист</a>
        </div>
    </div> --}}
    <div class="col-lg-12">
        <div class="row" id="results-container"></div>
    </div>
</div>
<script>
    function showSearchResult(html) {
        $('#results-container').html(html);
    }
</script>
@endsection