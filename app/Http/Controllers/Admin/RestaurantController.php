<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Restaurant;
use App\Consumable;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get restaurants
        $restaurants = Restaurant::get();

        // return index view with restaurants
        return view('admin.restaurant.index', ['restaurants' => $restaurants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // current restaurant
        $restaurant = Restaurant::find($id);

        // return view with current restaurant
        return view('admin.restaurant.edit', ['restaurant' => $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // current rest id
        $restaurant = restaurant::find($id);
        // all user input
        $Data = $request->all();
        // validate user input
        $validateArray = [
            'title' => ['required', 'string', 'max:255', Rule::unique('restaurants')->ignore($restaurant->id)],
            'address' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:7'],
            'city' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', Rule::unique('restaurants')->ignore($restaurant->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('restaurants')->ignore($restaurant->id)],
        ];

        // updates current restaurant with validated data
        $restaurant->update($Data);
        
        // redirect to index
        return redirect()->route('admin.restaurants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // current restaurant id
        $restaurant = Restaurant::find($id);
        // delete current restaurant
        $restaurant->delete();

        // collects all consumables from restaurant
        $consumables = Consumable::where('restaurant_id', $restaurant->id)->get();
        foreach ($consumables as $consumable) {
            // delete consumables from targeted restaurant
            $consumable->delete();
        }

        // redirect index
        return redirect()->route('admin.restaurants.index');
    }
}
