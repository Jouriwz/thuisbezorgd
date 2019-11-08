<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Restaurant;
use App\User;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // returns the restaurant create view
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation for the input fields
        request()->validate([
            'title' => ['required', 'string', 'max:255', 'unique:restaurants'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:7'],
            'phone' => ['required', 'numeric', 'digits_between:8,12', 'unique:restaurants'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:restaurants']
        ]);

        // Create a new restaurant
        $restaurant = new Restaurant();
        $restaurant->title = $request->title;
        $restaurant->address = $request->address;
        $restaurant->city = $request->city;
        $restaurant->zipcode = $request->zipcode;
        $restaurant->phone = $request->phone;
        $restaurant->email = $request->email;
        $restaurant->user_id = Auth::id();
        $restaurant->save();

        return redirect()->route('restaurant.show', ['restaurant' => $restaurant->id]);
    }

    public function show($id)
    {
        // Variable to hold the current user
        $user = Auth::user();
        // variable that holds the current restaurant
        $rest = Restaurant::where('id', $id)->with('consumables')->get();

        // Creates the categories
        $food = [];
        $drinks = [];
        $sides = [];
        // Pushes the added consumables to their category
        foreach ($rest[0]->consumables as $key => $consumable) {
            switch ($consumable->category) {
                case 1:
                    array_push($food, $rest[0]->consumables[$key]);
                    break;
                case 2:
                    array_push($drinks, $rest[0]->consumables[$key]);
                    break;
                case 3:
                    array_push($sides, $rest[0]->consumables[$key]);
                    break;
            }
        }

        // returns the restaurant show view with all the categories and products
        return view('restaurants.show', [
            'rest' => $rest[0],
            'foods' => $food,
            'drinks' => $drinks,
            'sides' => $sides,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rest = Restaurant::find($id);
        return view('restaurants.edit', [
            'rest' => $rest
        ]);
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
        $rest = restaurant::find($id);
        $requestData = $request->all();
        $validateArray = [
            'address' => ['required', 'string', 'max:191'],
            'zipcode' => ['required', 'string', 'max:7'],
            'city' => ['required', 'string', 'max:191'],
        ];
        if ($request->title != $rest->title) {
            $validateArray += ['title' => ['required', 'string', 'max:191', 'unique:restaurants']];
        }
        if ($request->email != $rest->email) {
            $validateArray += ['email' => ['required', 'string', 'email', 'max:191', 'unique:restaurants']];
        }
        if ($request->phone != $rest->phone) {
            $validateArray += ['phone' => ['required', 'numeric', 'digits_between:8,12', 'unique:restaurants']];
        }
        if ($request->title != $rest->title) {
            $validateArray += ['title' => ['required', 'string', 'max:191', 'unique:restaurants']];
        }

        $rest->update($requestData);
        return redirect()->route('profile.index');
        dd($request);

    }

    public function search(Request $request)
    {
        // Variable to holds the given request
        $query = $request['query'];
        // compares the request to the data in the database
        $results = Restaurant::where('title', 'like', '%'.$query.'%')->get();
        // returns the blade with the given input and the results.
        return view('restaurants.search', [
            'results' => $results,
            'query' => $query
        ]);
    }
}
