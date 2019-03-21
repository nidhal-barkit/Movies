<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
</head>
<body>
<div class="container page-top">
    <div class="row">
        @foreach ($movies  as $m)
            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                <img  src="{{asset($m->image)}}" alt="">
            </div>
        @endforeach
    </div>
</div>
</body>
</html>