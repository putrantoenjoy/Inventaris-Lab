<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CobaController extends Controller
{
    //detail pengadaan
    public function AddToPengadaan(Request $request, $id){
    	$product = DB::table('products')->where('id',$id)->first();

    	$check = DB::table('pengadaans')->where('product_id',$id)->first();

    	if ($check) {
    	DB::table('pengadaans')->where('product_id',$id)->increment('product_quantity');

        $product = DB::table('pengadaans')->where('product_id',$id)->first();
        $subtotal = $product->product_quantity * $product->selling_price;
        DB::table('pengadaans')->where('product_id',$id)->update(['sub_total'=> $subtotal]);

    	}else{
    	$data = array();
    	$data['product_id'] = $id;
    	$data['product_code'] = $product->product_code;
    	$data['product_name'] = $product->product_name;
    	$data['product_quantity'] = 1;
    	$data['selling_price'] = $product->selling_price;
    	$data['sub_total'] = $product->selling_price;

    	DB::table('pengadaans')->insert($data);
    	}
    }

    public function DetailProduct(){
        $pengadaan = DB::table('pengadaans')->get();
        return response()->json($pengadaan);
    }



    public function removeDetail($id){
        DB::table('pengadaans')->where('id',$id)->delete();
        return response('Done');

    }


    public function increment($id){
        $quantity = DB::table('pengadaans')->where('id',$id)->increment('product_quantity');

        $product = DB::table('pengadaans')->where('id',$id)->first();
        $subtotal = $product->product_quantity * $product->selling_price;
        DB::table('pengadaans')->where('id',$id)->update(['sub_total'=> $subtotal]);
        return response('Done');
    }


    public function decrement($id){
        $quantity = DB::table('pengadaans')->where('id',$id)->decrement('product_quantity');

        $product = DB::table('pengadaans')->where('id',$id)->first();
        $subtotal = $product->product_quantity * $product->selling_price;
        DB::table('pengadaans')->where('id',$id)->update(['sub_total'=> $subtotal]);
        return response('Done');
    }

    public function GetProductPengadaan($id){

        $product = DB::table('products')
            ->where('category_id',$id)
            ->get();
            return response()->json($product);
 
    }
}
