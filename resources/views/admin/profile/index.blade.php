@extends('layouts.admin')
@section('content')

<table class="table table-bordered" style="background-color: #f5f5dc;">
    <thead style="background-color: #40e0d0;">
        <tr>
            <th scope="col">Id</th>
			<th scope="col">Name</th>
			<th scope="col">Address</th>
			<th scope="col">number</th>
            <th scope="col">Email</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <th scope="col">Orders</th>
        </tr>
	</thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th>{{$user->id}}</th>
            <td>{{$user->name}}</td>
			<td>{{$user->address}} {{$user->zipcode}} </td>
			<td>{{$user->phone}}</td>
			<td>{{$user->email}}</td>
			<td><a href="{{route('admin.profiles.edit', ['profile' => $user->id])}}" class="btn btn-success">Edit</a></td>
			<td>
				<form action="{{route('admin.profiles.destroy', ['profile' => $user->id])}}" method="POST">
				@csrf
				@method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
				</form>
			</td>
            <td><a href="{{route('admin.orders', ['id' => $user->id])}}" class="btn btn-primary">Orders</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
