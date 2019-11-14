<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Consumable;

class ConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Stores the restaurant consumables in a variable
        $consumables = Consumable::with('restaurant')->get();
        // Names each category Id
        foreach ($consumables as $key => $consumable) {
            switch ($consumable->category) {
                case 1:
                    $consumables[$key]['category'] = 'Main Course';
                    break;
                case 2:
                    $consumables[$key]['category'] = 'Drinks';
                    break;
                case 3:
                    $consumables[$key]['category'] = 'Side Dish';
                    break;
            }
        }
        
        return view('admin.consumable.index', ['consumables' => $consumables]);
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
        // find current consumable ID
        $consumable = Consumable::find($id);

        return view('admin.consumable.edit', ['consumable' => $consumable]);
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
        $consumable = Consumable::find($id);
        $data = $request->all();
        $validateArray = [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'numeric'],
            'price' => ['required', 'numeric',],
        ];
 
        $consumable->update($data);

        return redirect()->route('admin.consumables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consumable = Consumable::find($id);
        $consumable->delete();
        
        return redirect()->route('admin.consumables.index');
    }
}
