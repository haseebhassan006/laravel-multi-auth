<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\IProductRepository;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public  $product;
    
    public function __construct(IProductRepository $product)
    {
        $this->product = $product;
    }

    public function index(){
        return  $products = $this->user->getAllProducts();   
    }

    public function store(Request $request,StoreProductRequest $srequest){

        $validated = $srequest->validated();
        
        $name = "";
        if ($request->hasfile('thumbnail')) {

            $file = $request->file('thumbnail')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::slug($filename, '-')  . "-" . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('app/agent/file'), $name);
        } else
            $name = "";
           

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount_percent' => $request->discount,
            'discount_price' => $request->discount_price,
            'quantity' => $request->quantity,
            'thumbnail' => $name
        ]);

        if($product) {
            $product->categories()->attach($request->category_id,['created_at'=>now(), 'updated_at'=>now()]);
            $response = ["message" => "Product Created Successfully"];
            return response($response, 200);
       
        } else {
            $response = ["message" =>'Failed To Create Product'];
            return response($response, 422);
        }

    }

    public function update(Request $request,$id,StoreProductRequest $srequest){

        $validated = $srequest->validated();
        
        $name = "";
        if ($request->hasfile('thumbnail')) {

            $file = $request->file('thumbnail')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::slug($filename, '-')  . "-" . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('app/agent/file'), $name);
        } else
            $name = $request->thumbnail;
           
          $product = Product::find($id);     
          $product->title = $request->title;
          $product->description = $request->description;
          $product->price =  $request->price;
          $product->discount_percent =  $request->discount;
          $product->discount_price =  $request->discount_pric;
          $product->quantity =  $request->quantity;
          $product->thumbnail = $name;
     

        if($product) {
            $product->categories()->attach($request->category_id,['created_at'=>now(), 'updated_at'=>now()]);
            $response = ["message" => "Product Created Successfully"];
            return response($response, 200);
       
        } else {
            $response = ["message" =>'Failed To Create Product'];
            return response($response, 422);
        }

    }


    public function delete($id){

        $product = Product::find($id);

        if($product->delete()){
            $product->categories->detach();
            $response = ["message" => "Product Deleted Successfully"];
            return response($response, 200);
        }else{
            $response = ["message" => "Something Went Wrong"];
            return response($response, 422);

        }

    }
}
