@extends('layouts.app')
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet" type="text/css">

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach (Alert::getMessages() as $type => $messages)
                @foreach ($messages as $message)
                    <div class="alert alert-{{ $type }}">{{ $message }}</div>
                @endforeach
            @endforeach
            @if(Auth::user()->getRole() != "Admin")
                <a href="/movies/create"> <button class="btn btn-primary mb-2">Ajouter un film</button></a>
                <br>
             @endif
            <div class="card">
                <div class="card-header">{{ __('Mes Films') }}</div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Année</th>
                            <th>Statut</th>
                            <th>Auteur</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($movies  as $movie)
                        <tr>

                            <td><img src="{{asset($movie->image)}}" width="80" height="80"> </td>
                            <td>{{$movie->title}}</td>
                            <td>{{$movie->year}}</td>
                            <td>@if($movie->published ==0)<span class="badge badge-danger">Non publié</span> @else <span class="badge badge-primary">Publié</span> @endif</td>
                            <td><b>{{$movie->getUserName()}}</b></td>
                            <td>
                                <a href="/movies/{{$movie->id}}/edit"><button class="btn btn-primary"> MÄJ</button></a>
                                <form action="{{url('/movies/'.$movie->id)}}"  method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                    <input type="hidden" name="id" value="{{$movie->id}}">
                                </form>

                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Année</th>
                            <th>Statut</th>
                            <th>Auteur</th>
                            <th>Options</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection
