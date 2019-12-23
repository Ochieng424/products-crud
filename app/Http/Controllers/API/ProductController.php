<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();
        $parent_array = array();

        foreach ($products as $product){

            $child_array = array(
                'id' => $product['id'],
                'productNumber' => $product['productNumber'],
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'description' => $product['description'],
                'image' => Storage::url($product['imgPath'])
            );

            array_push($parent_array, $child_array);
        }

        return collect($parent_array)->paginate(10);
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
            'name' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required',
            'description' => 'required|string',
            'files' => 'required',
//            'files.*' => 'image|mimes:jpg,png'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->productNumber = time();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $filename = Storage::putFileAs(
                    'public/uploads', $uploadedFile, time() . $uploadedFile->getClientOriginalName()
                );
                $product->imgPath = $filename;
            }
        }

        $product->save();

        return response(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($productNo)
    {
        $product = Product::where('productNumber', $productNo)->first();

        $details_array = array(
            'id' => $product['id'],
            'productNumber' => $product['productNumber'],
            'name' => $product['name'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
            'description' => $product['description'],
            'created_at' => $product['created_at'],
            'image' => Storage::url($product['imgPath'])
        );

        return collect($details_array)->toJson();
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
        $this->validate($request, [
            'name' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required',
            'description' => 'required|string',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $filename = Storage::putFileAs(
                    'public/uploads', $uploadedFile, time() . $uploadedFile->getClientOriginalName()
                );
                $product->imgPath = $filename;
            }
        }

        $product->update();

        return response(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response(['status' => 'success'], 200);
    }
}
