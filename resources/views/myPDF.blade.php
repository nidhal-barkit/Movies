<!DOCTYPE html>
<html>
<head>
    <title>VoirFilm - 2019</title>
    <style>
        body { margin: 0; background: #333; }
        header {
            padding: .5vw;
            font-size: 0;
            display: -ms-flexbox;
            -ms-flex-wrap: wrap;
            -ms-flex-direction: column;
            -webkit-flex-flow: row wrap;
            flex-flow: row wrap;
            display: -webkit-box;
            display: flex;
        }
        header div {
            -webkit-box-flex: auto;
            -ms-flex: auto;
            flex: auto;
            width: 200px;
            margin: .5vw;
        }
        header div img {
            width: 100%;
            height: auto;
        }
        @media screen and (max-width: 400px) {
            header div { margin: 0; }
            header { padding: 0; }

        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="row col-md-12">
            <header>
                @foreach($movies as $key => $movie)
                <div>
                    <img src="{{asset($movie->image)}}" alt>
                </div>
                @endforeach
            </header>

        </div>
    </div>
</div>
</body>
</html>