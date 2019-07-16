<?php
namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Custom;
use App\Http\Controllers\Controller;
use App\Space\Custom\Product;

class ProductsController extends Controller
{
    public function show(Request $request)
    {
		$filter = $request->input('filter');
		$sort = json_decode($request->input('sort'));
		$order = $sort->order ?? 'desc';
		$fieldName = $sort->fieldName ?? 'created_at';
		//print_r($sort);die;
		return Product::where('name', 'LIKE', '%'. strtolower($filter) . '%' )
				->orderBy($fieldName, $order)
				->paginate(5);
				
    }
	
	/**
     * Save a Product
     *
     * @param Requests\ProductRequest $request
     * @return View
     */
    public function store(Custom\ProductsRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
		$product->stock = $request->stock;
        $product->save();
		
        return response()->json([
            'message' => __('products.saved'),
            'product' => $product
        ],200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message' => __('products.deleted')
        ],200);
    }
}
