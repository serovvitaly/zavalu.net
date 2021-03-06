<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>База знаний</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery.min.js"></script>
    <script>
        function call(ops) {
            var params = $.extend({
                type: 'get',
                dataType: 'json',
                success: function(response, textStatus, jqXHR){
                    if (ops.success != undefined) { ops.success(response, textStatus, jqXHR); }
                    if (response.success == undefined || !response.success) { return null; }
                    try { window[response.method](response.data); }
                    catch(err) { console.log(err); }
                }
            }, ops);
            $.ajax(params);
        }
    </script>
    <style>
        .preloader{
            background: url(/img/preloader.gif);
            height: 50px;
            width: 50px;
            margin: 10px auto;
        }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
</html>