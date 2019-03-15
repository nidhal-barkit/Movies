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
                <div class="card-header">{{ __('Mettre à jour Film') }}</div>

                <div class="card-body">
                    <form action="/mymovies/{{$movie->id}}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="types" class="col-md-4 col-form-label text-md-right">Type</label>
                            <div class="col-md-6">

                                <select name="types[]" multiple  class="form-control" data-live-search="true" id="types">
                                    @foreach ($types as $type)
                                    <option  value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('types'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('types') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Titre" class="col-md-4 col-form-label text-md-right">Titre</label>
                            <div class="col-md-6">
                                <input id="titre" type="text" value="{{$movie->title}}" class="form-control{{ $errors->has('titre') ? ' is-invalid' : '' }}" name="titre" value="{{ old('titre') }}" required autofocus>
                                @if ($errors->has('titre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('titre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
                            <div class="col-md-6">
                                <input id="image" onchange="document.getElementById('output').src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" value="{{ old('image') }}"  autofocus>
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Aperçu</label>
                            <div class="col-md-6">
                                <img src="{{asset($movie->image)}}" width="150" height="200" id="output">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-md-4 col-form-label text-md-right">Année</label>
                            <div class="col-md-6">
                                <input id="year" type="text" value="{{$movie->year}}" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" value="{{ old('year') }}" required autofocus>
                                @if ($errors->has('year'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" @if($movie->published == 1) checked @endif type="checkbox" value="0"  name="published" id="published" {{ old('published') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="published">
                                        {{ __('Publiée') }}
                                    </label>
                                </div>
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
