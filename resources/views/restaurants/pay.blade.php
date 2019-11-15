@extends('layouts.app')
@section('content')

<table class="table table-bordered table-light mt-4">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Consumable</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($cart as $cartItem)
		<tr>
		  <td>{{$cartItem->title}}</td>
		  <td>{{$cartItem->price}}</td>
		</tr>
    @endforeach
  </tbody>
</table>
<h3>Total: €{{$total}}<h3>
<a href="{{route('pay')}}" class="btn btn-success">Pay</a>

@endsection