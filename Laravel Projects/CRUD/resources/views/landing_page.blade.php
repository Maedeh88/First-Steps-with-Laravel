<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb" style="text-align: center; margin-top: 2%">
            <h2>Choose one of the options:</h2>
        </div>
    </div>
    <div class="pull-right" style="text-align: center; margin: 4% 4%">
        <a class="btn btn-primary" href="{{ route('index_currency') }}"> Digital Currencies</a>
    </div>
    <div class="pull-right" style="text-align: center; margin: 4% 4%">
        <a class="btn btn-primary" href="{{ route('index_banner') }}"> Banners</a>
    </div>
    <div class="pull-right" style="text-align: center; margin: 4% 4%">
        <a class="btn btn-primary" href="{{ route('index_banner_type') }}"> Banner types</a>
    </div>
</div>
</body>
</html>
