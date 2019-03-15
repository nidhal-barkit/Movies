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

            <div class="card">
                <div class="card-header">{{ __('Utilisateurs') }}</div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Créé Le</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no =1 ;?>
                        @foreach($users  as $user)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>@if($user->getRole() == "Admin")<span class="badge badge-secondary">{{$user->getRole()}}</span>
                                @else <span class="badge badge-success">{{$user->getRole()}}</span> @endif</td>

                            <td>{{$user->created_at}}</td>

                            <td>@if($user->status == 0)<span class="badge badge-danger">Innactive</span>
                                @else <span class="badge badge-primary">Active</span> @endif</td>
                            <td>@if($user->getRole() != "Admin")
                                <a href="/users/{{$user->id}}/edit"><button class="btn btn-primary">Mettre à jour</button></a>

                                <form action="{{url('/users/'.$user->id)}}"  method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Créé Le</th>
                            <th>Status</th>
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
