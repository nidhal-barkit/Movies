@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach (Alert::getMessages() as $type => $messages)
                @foreach ($messages as $message)
                    <div class="alert alert-{{ $type }}">{{ $message }}</div>
                @endforeach
            @endforeach

            <div class="card">
                <div class="card-header">{{ __('Mettre à jour') }} <b>{{$user->name}}</b></div>

                <div class="card-body">
                    <form action="/users/{{$user->id}}"  method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-6">

                                <select name="role"   class="form-control" data-live-search="true" id="role">
                                    @foreach ($roles as $role)
                                    <option @if($user->getRole() == $role->type) selected @endif value="{{$role->id}}">{{$role->type}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Titre" class="col-md-4 col-form-label text-md-right">Nom& prénom </label>
                            <div class="col-md-6">
                                <input id="titre" type="text" value="{{$user->name}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"  autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Titre" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input id="titre" type="text" value="{{$user->email}}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="roles" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">

                                <select name="status" class="form-control" data-live-search="true" >

                                  <option @if($user->status == 1) selected @endif value="1">Active</option>
                                  <option @if($user->status == 0) selected @endif value="0">Innactive</option>

                                </select>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Mise à jour') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
