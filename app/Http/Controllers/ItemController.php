<?php

namespace App\Http\Controllers;

use App\Item;
use File;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $items = Item::where('name', 'LIKE', '%'.$q.'%')
            ->orWhere('price', 'LIKE', '%'.$q.'%')
            ->orWhere('description', 'LIKE', '%'.$q.'%')
            ->orderBy('name')->paginate(10);
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
            'name' => 'required',
            'price' => 'required',
            // 'image' => 'mimes:jpg,jpeg,png|max:10240',
            'description' => 'required'
        ]);
        
        $existFile = '';
        if ($request->image) {
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png'; 
            }
            $fileName = str_random().'.'.$extension;
            $path = public_path().'/image/'.$fileName;
            file_put_contents($path, $decoded);            
            $existFile .= $fileName;
        }

        $item = new Item;
        $item->create($request->except('image') + [
            'image' => $existFile
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);


        $exploded = explode(',', $request->image);
        if (array_key_exists(1, $exploded)) {
            // Komen Bagian ini jika file sebelumnya tidak mau di hapus
            if ($item->image) {
                $itemImage = public_path("image/{$item->image}"); // get previous image from folder
                if (File::exists($itemImage)) { // unlink or remove previous image from folder
                    unlink($itemImage);
                }            
            }

            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } else {
                $extension = 'png'; 
            }
            $fileName = str_random().'.'.$extension;
            $path = public_path().'/image/'.$fileName;
            file_put_contents($path, $decoded);            

            $item->image = $fileName;
        }

        $item->name = $request->name;
        $item->price = $request->price;
        $item->save();

        // $item->name = $request->name;
        // $item->update($request->except('image') + [
        //     'image' => $fileName
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
