@extends('layouts.app')
@section('style')

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
            <div class="row col-md-12">
                @if(Auth::user()->getRole() != "Admin")
                    <a href="/movies/create"> <button class="btn btn-primary mb-2">Ajouter un film</button></a>
                @endif
                    @if(Auth::user()->getRole() == "Admin")
                        <a href="/excelonesheet">
                        <button type="button" class="btn btn-dark mb-2">Export</button>
                        </a>
                        <button type="button" class="btn btn-primary mb-2 ml-4" data-toggle="modal" data-target="#myModal">Import</button>
                        <a href="/pdf">
                            <button type="button" class="btn btn-danger mb-2 ml-4">Fichier PDF</button>
                        </a>
                    @endif
            </div>

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
                                <a href="/movies/{{$movie->id}}/edit"><button class="btn btn-primary">M Ä J</button></a>
                                <form action="{{url('/movies/'.$movie->id)}}"  method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
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

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="text-align: left">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form action="{{ route('importonesheet') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                        <input type="file" name="file" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Import Excel File</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
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
