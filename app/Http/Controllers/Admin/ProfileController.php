<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Consumable;
use App\Order;
use App\User;
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
        $users = User::all();
        
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
        $user = User::find($id);

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
        $user = User::find($id);
        $data= $request->all();
        // Create an array with things to validate if the form gets submitted
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->zipcode = $request->input('zipcode');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = bcrypt(request('password'));

        if (isset($data['is_admin'])) {
            $data['is_admin'] = 1;
        } else {
            $data['is_admin'] = 0;
        }

        // Updates the requested data
        $user->save();

        return redirect()->route('admin.profiles.index')->with('status', 'Profiel van '.$user->name.' succesvol bijgewerkt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.profiles.index');
    }
}
