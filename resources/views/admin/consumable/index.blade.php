@extends('layouts.admin')
@section('content')

<table class="table table-bordered" style="background-color: #f5f5dc;">
    <thead style="background-color: #40e0d0;">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">name</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Restaurant</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($consumables as $consumable)
        <tr>
            <th>{{$consumable->id}}</th>
            <td>{{$consumable->title}}</td>
            <td>{{$consumable->category}}</td>
            <td>{{$consumable->price}}</td>
            <td>{{$consumable['restaurant']->title}}</td>
            <td><a href="{{route('admin.consumables.edit', ['consumable' => $consumable->id])}}" class="btn btn-success">Edit</a></td>
            <td>
                <form action="{{route('admin.consumables.destroy', ['consumable' => $consumable->id])}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



{{-- @if(count($consumables))
@foreach($consumables as $consumable)
  <div class="modal fade" id="delete{{$consumable->id}}" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Gegevens van {{$consumable->title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Weet je zeker dat je de versnapering {{$consumable->title}} wilt verwijderen?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            <form action="{{route('admin.consumables.destroy', ['consumable' => $consumable->id])}}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Ja</button>
            </form>
        </div>
    </div>
</div>
</div>
@endforeach
@endif --}}
@endsection
