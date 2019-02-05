<!doctype html>
<html lang="en">
<head>
    <title>Courses</title>
    <meta charset="UTF-8">
    <meta title="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Amiri" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
</head>
<body>

<div class="header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 order-last" style="background: #6574cd">
                <a href="#" class="pull-right">
                    <img src="{{ asset('img/logo2.png') }}">
                </a>
            </div>

            <div class="col-6" style="background: red;">
                <button class="navbar-toggler order-first" type="button" data-toggle="collapse"
                        data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
        {{--<div class="collapse navbar-collapse" id="navbarText">--}}
        {{--<ul class="navbar-nav mr-auto">--}}
        {{--<li class="nav-item active">--}}
        {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">Features</a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">Pricing</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--<a class="navbar-brand" href="#">--}}
        {{--<img src="{{ asset('img/logo2.png') }}" width="30" height="30" alt="">--}}
        {{--</a>--}}
        {{--</div>--}}

    </div>
</div>

<div class="container mt-4" style="background: #6574cd;">
    <div class="row justify-content-center">
        <div class="col-lg-10" style="background: #857b26;">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-4" style="background: #4c110f; height: 300px;">
                        <img class="card-img-top" src="{{ asset('img/adv.png') }}" alt="Card image cap"
                             style="height: 300PX;">
                    </div>
                    <div class="col-8" style="background: #1d643b; height: 300px;">
                        <img class="card-img-top" src="{{ asset('img/event.png') }}" alt="Card image cap"
                             style="height: 300PX;">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-2">
        <div class="col-8">
            <h1 class="text-right">آخر الفعاليات</h1>
        </div>
    </div>


</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>