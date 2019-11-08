@extends('layouts.app')
@section('content')

<section class="jumbotron text-center mt-4">
    <div class="container">
        <h1 class="jumbotron-heading">{{$rest->title}}</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator,
            etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
            @if(!$isOpen)
			<h4 class="text-center">{{$rest->title}} Opens on {{$rest->Openingtimes->open}}. You cant order right now</h4>
			@endif
        <p>
            <a href="/" class="btn btn-primary my-1">Back</a>
        </p>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4>Main Course</h4>
                <hr>
                @if(count($foods))
                    @foreach($foods as $food)
                        <div class="card text-left mb-1">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <img src="//placehold.it/200" class="img-fluid" alt="">
                                </div>
                                <div class="col">
                                    <div class="card-block px-2">
                                        <h3 class="card-title mt-1">{{$food->title}}</h3>
                                        <h4 class="card-text">€{{$food->price}}</h4>
                                        <a href="#" class="btn btn-primary">Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>{{$rest->title}} Has nothing for sale at the moment.</h4>
                @endif
                <hr>
                
                <h4>Drinks</h4>
                <hr>
                @if(count($drinks))
                    @foreach($drinks as $drink)
                        <div class="card text-left mb-1">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <img src="//placehold.it/200" class="img-fluid" alt="">
                                </div>
                                <div class="col">
                                    <div class="card-block px-2">
                                        <h3 class="card-title mt-1">{{$drink->title}}</h3>
                                        <h4 class="card-text">€{{$drink->price}}</h4>
                                        <a href="#" class="btn btn-primary">Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>{{$rest->title}} Has nothing for sale at the moment.</h4>
                @endif
                <hr>

                <h4>Side Dishes</h4>
                <hr>
                @if(count($sides))
                    @foreach($sides as $side)
                        <div class="card text-left mb-1">
                            <div class="row no-gutters">
                                <div class="col-auto">
                                    <img src="//placehold.it/200" class="img-fluid" alt="">
                                </div>
                                <div class="col">
                                    <div class="card-block px-2">
                                        <h3 class="card-title mt-1">{{$side->title}}</h3>
                                        <h4 class="card-text">€{{$side->price}}</h4>
                                        <a href="#" class="btn btn-primary">Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>{{$rest->title}} Has nothing for sale at the moment.</h4>
                @endif
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection
