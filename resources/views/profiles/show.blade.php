@extends('layouts.app')
@section('content')

<div class="row mt-3">
    {{-- Account Details --}}
    <div class="col-md-12 mt-1">
        <div class="card mb-1 shadow-sm">
            <div class="card-header font-weight-bold">
                Account Details
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span class="font-weight-bold">Name:</span> {{$user->name}}</li>
                <li class="list-group-item"><span class="font-weight-bold">Address:</span> {{$user->address}}</li>
                <li class="list-group-item"><span class="font-weight-bold">Zipcode:</span> {{$user->zipcode}}</li>
                <li class="list-group-item"><span class="font-weight-bold">City:</span> {{$user->city}}</li>
                <li class="list-group-item"><span class="font-weight-bold">Phone:</span> {{$user->phone}}</li>
                <li class="list-group-item"><span class="font-weight-bold">Email:</span> {{$user->email}}</li>
            </ul>
            <div class="d-flex align-items-center mt-3">
                @if(Auth::user())
                    @if(auth()->user()->id == $user->id)
                        <a href="/" class="btn btn-primary" role="button">Back</a>
                        <a href="/profile/{{$user->id}}/edit" class="btn btn-success" role="button">Edit Profile</a>
                    @else
                        <a href="/" class="btn btn-primary" role="button">Back</a>
                    @endif
                @else
                    <a href="/" class="btn btn-primary" role="button">Back</a>
                @endif
            </div>
        </div>
    </div>
    {{-- Orders --}}
    <div class="col-md-12 mt-1">
        <div class="card mb-1 shadow-sm">
            <div class="card-header font-weight-bold">
                Orders
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Order: </li>
                <li class="list-group-item">Products: </li>
                <li class="list-group-item">Price: </li>
            </ul>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Restaurants --}}
    <div class="col-md-12 mt-1">
        <div class="card mb-1 shadow-sm">
            <div class="card-header font-weight-bold">
                Restaurants
            </div>
                <div class="row justify-content-center">
                    @if(count($user->restaurants)) 
                        @foreach($user->restaurants as $restaurant)
                            <div class="card m-1" style="width: 18rem; background-color: #f5f5dc;">
                                <img class="bd-placeholder-img card-img-top" width="200" height="180" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{$restaurant->title}}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <div class="btn-group">
                                        <a href="/restaurant/{{$restaurant->id}}" class="btn btn-primary">Go to</a>
                                        <a href="{{route('restaurant.edit', ['restaurant' => $restaurant->id])}}" class="btn btn-success">Edit</a>
                                        <a href="{{route('consumable.create', ['restaurant_id' => $restaurant->id])}}" class="btn btn-primary">add
                                            product</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>You dont own a restaurant</h3>
                    @endif
                </div>    
            <a href="{{route('restaurant.create')}}" class="btn btn-primary"> Restaurant toevoegen</a>
        </div>
    </div>
</div>
@endsection
