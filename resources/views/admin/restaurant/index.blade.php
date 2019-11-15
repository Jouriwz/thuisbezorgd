@extends('layouts.admin')
@section('content')

<table class="table table-bordered" style="background-color: #f5f5dc;">
    <thead style="background-color: #40e0d0;">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Owner id</th>
            <th scope="col">Email</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <th scope="col">View</th>
        </tr>
    </thead>
    <tbody>
        @foreach($restaurants as $restaurant)
        <tr>
            <th>{{$restaurant->id}}</th>
            <td>{{$restaurant->title}}</td>
            <td>{{$restaurant->user_id}}</td>
            <td>{{$restaurant->email}}</td>
            <td><a href="{{route('admin.restaurants.edit', ['restaurant' => $restaurant->id])}}"
                    class="btn btn-success">Edit</a></td>
            <td>
                <form action="{{route('admin.restaurants.destroy', ['restaurant' => $restaurant->id])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
            <td><a href="{{route('restaurant.show', ['restaurant' => $restaurant->id])}}"
                    class="btn btn-warning">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
