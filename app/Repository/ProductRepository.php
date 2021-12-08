<?php
namespace App\Repository;

use App\Models\Product;
use App\Repository\IProductRepository;
use Illuminate\Support\Facades\Hash;

class ProductRepository implements IProductRepository
{
    public function getAllProducts(){

        $q=request('query');
        $products= Product::where('title', 'like', '%' . $q . '%')
        ->latest()->paginate((int)env('PER_PAGE'));
        return response()->json(['products',$products]);
        
    }

}