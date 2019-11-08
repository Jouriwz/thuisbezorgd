@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    
    {{-- Search Bar --}}
    <form action="{{route('search')}}" method="POST" class="input-group mb-3 mt-3">
    @csrf
        <input class="form-control border border-danger mr-sm-2" type="search" placeholder="search" name="query" aria-label="Search" style="background-color: #f5f5dc;">
         <button class="btn btn-danger btn-sm my-0" type="submit">Search</button>
    </form>

    {{-- Restaurants --}}
    @if(count($rests) > 0)
        @foreach( $rests as $rest)
            <div class="card m-1" style="width: 18rem; background-color: #f5f5dc;">
                <img class="bd-placeholder-img card-img-top" width="200" height="180" src="./images/restaurants/{{$rest->image}}" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$rest->title}}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/restaurant/{{$rest->id}}" class="btn btn-primary">Go to {{ $rest->title }}</a>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
