<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Restaurant;
use App\User;
use App\Consumable;
use App\Openingtime;
use App\Order;
use Carbon\Carbon;

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:restaurants'],
            'open' => ['required'],
            'close' => ['required']
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

        // Create the openingtimes for the restaurant
        $openingtimes = new Openingtime();
        $openingtimes->restaurant_id = $restaurant->id;
        $openingtimes->open = $request->open;
        $openingtimes->close = $request->close;
        $openingtimes->save();

        return redirect()->route('restaurant.show', ['restaurant' => $restaurant->id]);
    }

    public function show($id)
    {
        // Variable to hold the current user
        $user = Auth::user();
        // variable that holds the current restaurant
        $rest = Restaurant::where('id', $id)->with('consumables', 'openingtimes')->get();
        // Store the opening, closing and current time in a variable
        $open = $rest[0]->openingtimes->open;
        $close = $rest[0]->openingtimes->close;
        $now = carbon::now()->format('H:i:s');
        // If the restaurant is open now, return 1
        if ($now >= $open && $now <= $close) {
            $isOpen = 1;
        } else {
            $isOpen = 0;
        }
        
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
            'isOpen' => $isOpen,
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
    public function checkout($restaurant_id)
    {
        // Get the consumables arrey from the session cookie
        $items = session()->get('consumables');
        // Get all the data for each item
        $cart = [];
        foreach ($items as $key => $item) {
            array_push($cart, Consumable::where('id', $item)->get()[0]);
        }
        // Calculate the total price
        $total = 0;
        foreach ($cart as $cartItem) {
            $total += $cartItem['price'];
        }
        // Format the total price and put it in the session
        $total = number_format($total, 2);
        session()->put('total', $total);
        return view('restaurants.pay', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function pay($restaurant_id)
    {
        // Retrieve all the consumables and the total price
        $items = session()->get('consumables');
        $total = session()->get('total');

        $order = new Order();
        $order->user_id = Auth::id();
        $order->restaurant_id = $restaurant_id;
        $order->total = $total;
        $order->save();

        // Attach each consumable to the order
        foreach ($items as $item) {
            $order->consumables()->attach($item, ['quantity' => 1]);
        }

        return redirect()->route('profile.index')->with('status', 'Betaling geslaagd!');
    }
    
}
