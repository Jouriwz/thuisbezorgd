<?php

namespace App\Http\Controllers;

use App\Consumable;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // returns the consumable create view with the current user ID
        return view('consumables.create', ['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $restaurant_id)
    {
        // Validation for the input fields
        request()->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        // Adds the user input to the database
        $consumable = new Consumable();
        $consumable->title = $request->title;
        $consumable->category = $request->category;
        $consumable->price = $request->price;
        $consumable->restaurant_id = $restaurant_id;
        $consumable->save();

        // returns the restaurant show view with the restaurant ID
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function show(Consumable $consumable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function edit(Consumable $consumable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consumable $consumable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function destroy($restaurant_id, Consumable $consumable)
    {
        // Destroy the selected consumable
        Consumable::destroy($consumable->id);
        return redirect()->back();
    }

}
