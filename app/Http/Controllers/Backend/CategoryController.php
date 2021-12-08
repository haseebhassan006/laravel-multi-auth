<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index(){
        
        $q=request('query');
        $categoriess=Category::where('title', 'like', '%' . $q . '%')
        ->latest()->paginate((int)env('PER_PAGE'));
        return response()->json(['categories',$categories]);
    }

    public function store(Request $request){

        $request->validate([
            'name' => ['required'],
            'image' => ['required'],
            'description' => ['required'],
        
        ]);
        
        $name = "";
        if ($request->hasfile('image')) {

            $file = $request->file('thumbnail')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::slug($filename, '-')  . "-" . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('app/agent/file'), $name);
        } else
            $name = "";
           

        $category = Category::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $name
        ]);

        if($category) {
           
            $response = ["message" => "Category Created Successfully"];
            return response($response, 200);
       
        } else {
            $response = ["message" =>'Failed To Create Category'];
            return response($response, 422);
        }

    }

    public function update(Request $request,$id){

        $request->validate([
            'name' => ['required'],
            'image' => ['required'],
            'description' => ['required'],
        
        ]);
        
    
        if ($request->hasfile('image')) {

            $file = $request->file('thumbnail')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::slug($filename, '-')  . "-" . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('app/agent/file'), $name);
        } else
            $name = $request->old_image;
           

        $category = Category::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $name
        ]);

        if($category) {
           
            $response = ["message" => "Category Updated Successfully"];
            return response($response, 200);
       
        } else {
            $response = ["message" =>'Failed To Updated Category'];
            return response($response, 422);
        }

    }


    public function delete($id){

        $category = Category::find($id);
        if($category->delete()){
            $response = ["message" => "Category Deleted Successfully"];
            return response($response, 200);
        }else{
            $response = ["message" => "Something Went Wrong"];
            return response($response, 422);
        }

    }

}
