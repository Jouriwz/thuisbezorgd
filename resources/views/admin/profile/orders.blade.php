@extends('layouts.admin')
@section('content')

<table class="table table-bordered" style="background-color: #f5f5dc;">
    <thead style="background-color: #40e0d0;">
        <tr>
            <th>Id</th>
            <th>restaurant</th>
			<th>Created at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $key => $order)
        <tr>
            <th>{{$order->id}}</th>
            <td>{{$order->restaurant->title}}</td>
            <td>{{$order->created_at}}</td>
            {{-- <td><a href="{{route('admin.restaurants.edit', ['restaurant' => $restaurant->id])}}"
                    class="btn btn-success">Edit</a></td>
            <td>
                <form action="{{route('admin.restaurants.destroy', ['restaurant' => $restaurant->id])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
            <td><a href="{{route('restaurant.show', ['restaurant' => $restaurant->id])}}"
                    class="btn btn-warning">View</a></td> --}}
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
