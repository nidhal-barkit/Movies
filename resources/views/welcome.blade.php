<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>


        <!-- Styles -->
        <style>
            body {
                background-color:#000000 !important;
                font-family: "Asap", sans-serif;
                color:#989898;
                margin:10px;
                font-size:16px;
            }

            #demo {
                height:100%;
                position:relative;
                overflow:hidden;
            }


            .green{
                background-color:#6fb936;
            }
            .thumb{
                margin-bottom: 30px;
            }

            .page-top{
                margin-top:85px;
            }


            img.zoom {
                width: 100%;
                height: 200px;
                border-radius:5px;
                object-fit:cover;
                -webkit-transition: all .3s ease-in-out;
                -moz-transition: all .3s ease-in-out;
                -o-transition: all .3s ease-in-out;
                -ms-transition: all .3s ease-in-out;
            }


            .transition {
                -webkit-transform: scale(1.2);
                -moz-transform: scale(1.2);
                -o-transform: scale(1.2);
                transform: scale(1.2);
            }
            .modal-header {

                border-bottom: none;
            }
            .modal-title {
                color:#000;
            }
            .modal-footer{
                display:none;
            }
            #butt{
                margin-top: 20px;
                margin-right: 20px;
            }

        </style>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    </head>
    <body>
        <div style="text-align: right !important;" id="butt">
            @if (Route::has('login'))
                <div class="pull-right">
                    @auth
                        <a href="{{ url('/movies') }}"><button class="btn btn-outline-light text-right">Films</button></a>
                    @else
                        <a href="{{ route('login') }}"><button class="btn btn-outline-light  mr-4">Login</button></a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><button class="btn btn-outline-light text-right">Register</button></a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="container page-top">
            <div class="row">
                @foreach ($movies  as $m)
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a href="{{$m->image}}" class="fancybox" rel="ligthbox">
                        <img  src="{{asset($m->image)}}" class="zoom img-fluid "  alt="">
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function(){

                $(this).addClass('transition');
            }, function(){

                $(this).removeClass('transition');
            });
        });
    </script>
    </body>
</html>
