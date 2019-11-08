@extends('layouts.app')
@section('content')

<h3 class="mt-4 mb-3" style="font-weight: bold;">You searched on "{{$query}}"</h3>
@if(count($results) > 0)
	@foreach( $results as $result)
		<div class="card m-1" style="width: 18rem; background-color: #f5f5dc;">
			<img class="bd-placeholder-img card-img-top" width="200" height="180" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap">
			<div class="card-body">
				<h5 class="card-title">{{$result->title}}</h5>
				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				<a href="{{route('restaurant.show', ['restaurant' => $result->id])}}" class="btn btn-primary">Go to {{ $result->title }}</a>
			</div>
		</div>
	@endforeach
@else
	<h2>No results for "{{$query}}".</h2>	
@endif

@endsection