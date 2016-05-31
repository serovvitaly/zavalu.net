<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Molle:400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <style>
        h1,h2,h3,h4 {
            font-family: 'Open Sans Condensed',sans-serif;
            font-weight: bold;
        }
    </style>

</head>
<body>

<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12" id="topbar"></div>
        <div class="col-lg-12" id="header-main"></div>
    </div>
    @yield('content')
    <div class="row">
        <div class="col-lg-12" id="footer-top"></div>
        <div class="col-lg-12" id="footer-bottom"></div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
    function getSelectedItems(productId) {
        var inputsArr = $('#product-item-'+productId+' .product-counter:checked');
        var outputMix = [];

        console.log(inputsArr);

        inputsArr.each(function(){
            outputMix.push($(this).data('product-id') + ':' + $(this).val())
        });

        return outputMix.join('|');
    }
    function buyOneClick(productId){
        $('#buy-one-click-modal').modal('show');
        var mix = getSelectedItems(productId);
        console.log(mix);
        $.ajax({
            url: '/card/buy-one-click',
            dataType: 'json',
            type: 'get',
            data: {
                product_id: productId
            },
            success: function(json){
                $('#buy-one-click-modal .modal-body').html(json);
            }
        });
    }
    function addToCard(productId){
        alert('addToCard '+productId);
        $.ajax({
            url: '/card/add-to-card',
            dataType: 'json',
            type: 'get',
            data: {
                product_id: productId
            },
            success: function(json){
                console.log(json);
            }
        });
    }
</script>

</body>
</html>