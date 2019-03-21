<div class="content">
    <div class="row">
        <div class="col-md-12" style="text-align: center">
            <h2> <b>{{$data['name']}}</b></h2>
        </div>
        <div class="col-md-12" style="text-align: center">
            <img src="{{asset($data['image'])}}" width="250" height="400">
        </div>
        <div class="col-md-12" style="text-align: center">
            <p><b>Monsieur</b> {{$data['username']}} , {{$data['message']}}</p>
        </div>
    </div>
</div>

