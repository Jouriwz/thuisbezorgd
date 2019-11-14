@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #40e0d0;">{{ __('Edit product') }}</div>

                <div class="card-body" style="background-color: #f5f5dc;">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.consumables.update', ['consumable' => $consumable->id]) }}">
                        @method('PATCH')
                        @csrf

                        {{-- title --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $consumable->title}}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- price --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('price') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $consumable->price}}">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
                            <div class="col-md-6">
                                <select name="category" id="categoryInput" class="form-control">
                                    <option value="1" @if($consumable->category == 1) selected="selected" @endif>Main Course</option>
                                    <option value="2" @if($consumable->category == 2) selected="selected" @endif>Drinks</option>
                                    <option value="3" @if($consumable->category == 3) selected="selected" @endif>Side Dish</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit') }}
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

    {{-- <div class="form-group">
            <label for="photoInput">Afbeelding</label>
            <input type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photoInput" name="photo">
        </div> --}}