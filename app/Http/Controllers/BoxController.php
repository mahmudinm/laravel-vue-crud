<?php

namespace App\Http\Controllers;

use App\Box;
use App\Item;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxes = Box::orderBy('id', 'DESC')->paginate(10);
        $boxes->load('items');
        return response()->json($boxes);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        return response()->json($items);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',
            'name' => 'required',
            'weight' => 'required'
        ]);

        $box = new Box;
        $box->create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        $items = Item::all();
        $box->load('items');
        return response()->json([$box, $items]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Box $box)
    {
        $this->validate($request, [
            'item_id' => 'required',
            'name' => 'required',
            'weight' => 'required'
        ]);

        $box->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        $box->delete();
    }
}
