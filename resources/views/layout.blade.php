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
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

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
        body {
            background: url(/img/bg-body.png);
        }
        #main-container {
            -webkit-box-shadow: 0 0 1px #d5d5d5;
            box-shadow: 0 0 1px #d5d5d5;
            background: rgba(0, 0, 0, 0.1);
        }
        #topbar {
            min-height: 40px;
            text-transform: uppercase;
            font-size: 11px;
            background: white;
            line-height: 36px;
        }
        #header-main {
            min-height: 60px;
            background-color: #e57aac;
        }
        #header-main:before {
            background-image: url(/img/line-top-page.png);
            background-repeat: repeat-x;
            background-position: 0 0;
            position: absolute;
            content: "";
            bottom: -8px;
            left: 0px;
            width: 100%;
            height: 8px;
            z-index: 10;
        }
        #footer-top:before {
            background-image: url(/img/line-footer-page.png);
            background-repeat: repeat-x;
            background-position: 0 0;
            position: absolute;
            content: "";
            top: -8px;
            left: 0px;
            width: 100%;
            height: 8px;
        }
        #footer-top {
            background: #65c5f2;
            margin-top: 30px;
            min-height: 50px;
        }
        #footer-bottom {
            background: white;
            min-height: 50px;
        }
        .white-wrapper {
            background: white;
            margin: 0 -10px;
            padding: 10px;
        }
        .mini-item-input-text {
            width: 30px;
            height: 24px;
            padding: 0;
            text-align: center;
            margin: 0;
            font-size: 11px;
            font-weight: bold;
        }
    </style>

</head>
<body>

<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12" id="topbar">
            <div class="col-lg-9"></div>
            <div class="col-lg-3">
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#loginFormModal">Регистрация/Вход</a>
            </div>
        </div>
        <div class="col-lg-12" id="header-main"></div>
    </div>
    @yield('content')
    <div class="row">
        <div class="col-lg-12" id="footer-top"></div>
        <div class="col-lg-12" id="footer-bottom"></div>
    </div>
</div>

<!-- loginFormModal -->
<div class="modal fade" id="loginFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Вход</h4>
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <h4>Регистрация</h4>
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
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