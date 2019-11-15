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
        // Validation
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

        // Creates a new restaurant
        $restaurant = new Restaurant();
        $restaurant->title = $request->title;
        $restaurant->address = $request->address;
        $restaurant->city = $request->city;
        $restaurant->zipcode = $request->zipcode;
        $restaurant->phone = $request->phone;
        $restaurant->email = $request->email;
        $restaurant->user_id = Auth::id();
        $restaurant->save();

        // Creates openingtimes for the current restaurant
        $openingtimes = new Openingtime();
        $openingtimes->restaurant_id = $restaurant->id;
        $openingtimes->open = $request->open;
        $openingtimes->close = $request->close;
        $openingtimes->save();

        // redirect to show view with current restaurant
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
        $main = [];
        $drinks = [];
        $side = [];
        // Pushes the added consumables to their category
        foreach ($rest[0]->consumables as $key => $consumable) {
            switch ($consumable->category) {
                case 1:
                    array_push($main, $rest[0]->consumables[$key]);
                    break;
                case 2:
                    array_push($drinks, $rest[0]->consumables[$key]);
                    break;
                case 3:
                    array_push($side, $rest[0]->consumables[$key]);
                    break;
            }
        }

        // returns the restaurant show view with all the categories and products
        return view('restaurants.show', [
            'rest' => $rest[0],
            'foods' => $main,
            'drinks' => $drinks,
            'sides' => $side,
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
        // current rest id
        $rest = Restaurant::find($id);

        // return view with current rest
        return view('restaurants.edit', ['rest' => $rest]);
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
        $rest = restaurant::find($id);
        // get all user input
        $Data = $request->all();
        // validate user input
        $validateArray = [
            'address' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:7'],
            'city' => ['required', 'string', 'max:255'],
        ];
        
        // update current rest with new data
        $rest->update($Data);
        // dd($rest);
        // redirect index view
        return redirect()->route('profile.index');

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
        // get consumables fromm session
        $items = session()->get('consumables');
        // collect data for items
        $cart = [];
        foreach ($items as $key => $item) {
            array_push($cart, Consumable::where('id', $item)->get()[0]);
        }
        // adds the prices together for total cost
        $total = 0;
        foreach ($cart as $cartItem) {
            $total += $cartItem['price'];
        }
        // formats totalprice
        $total = number_format($total, 2);
        session()->put('total', $total);
        return view('restaurants.pay', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    public function pay($restaurant_id)
    {
        // gets all consumables and prices
        $items = session()->get('consumables');
        $total = session()->get('total');

        // creates a new order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->restaurant_id = $restaurant_id;
        $order->total = $total;
        $order->save();

        // adds the consumables to the order
        foreach ($items as $item) {
            $order->consumables()->attach($item, ['quantity' => 1]);
        }

        return redirect()->route('profile.index')->with('status', 'Betaling geslaagd!');
    }
    
}
