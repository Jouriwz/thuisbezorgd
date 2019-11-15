<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Consumable;
use Auth;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all users
        $users = User::all();
        
        // return index view with all users
        return view('admin.profile.index', ['users' => $users]);
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

    public function orders($id)
    {
        // Get logged in user with restaurants and orders
        $user = User::where('id', $id)->with('restaurants', 'orders')->get()[0];
        // Creates a empty array
        $orders = [];
        // checks of the user has orders
        if (count($user->orders)) {
            foreach ($user->orders as $key => $order) {
                // pushes the consumables of each order to the array
                array_push($orders, Order::where('id', $order->id)->with('consumables')->get()[0]);
            }
        }

        // returns the orders view with users and their orders
        return view('admin.profile.orders', [
            'user' => $user,
            'orders' => $orders
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
        // variable that current user id
        $user = User::find($id);

        // return edit view with current user
        return view('admin.profile.edit', ['user' => $user]);
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
        // current user id
        $user = User::find($id);
        // all user input
        $data= $request->all();
        // auth current user
        $user = Auth::user();
        // changes the data with the users input
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->zipcode = $request->input('zipcode');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = bcrypt(request('password'));

        // checks for is_admin
        if (isset($data['is_admin'])) {
            $data['is_admin'] = 1;
        } else {
            $data['is_admin'] = 0;
        }

        // Updates the requested data
        $user->save();

        // return index view
        return redirect()->route('admin.profiles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // currennt user
        $user = User::find($id);
        // delete current user
        $user->delete();

        // redirect index view
        return redirect()->route('admin.profiles.index');
    }
}
