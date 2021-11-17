<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Pengadaan;

class PengadaanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function AddToDetail(Request $request, $id){
    	$product = DB::table('products')->where('id',$id)->first();

    	$check = DB::table('pengadaans')->where('productid_pengadaan',$id)->first();

    	if ($check) {
    	DB::table('pengadaans')->where('productid_pengadaan',$id)->increment('product_quantity');

        $product = DB::table('pengadaans')->where('productid_pengadaan',$id)->first();
        $subtotal = $product->product_quantity * $product->selling_price;
        DB::table('pengadaans')->where('productid_pengadaan',$id)->update(['sub_total'=> $subtotal]);

        return response()->json($product);

    	}else{
    	$data = array();
    	$data['productid_pengadaan'] = $id;
    	$data['product_name'] = $product->product_name;
    	$data['product_code'] = $product->product_code;
    	$data['product_quantity'] = 1;
    	$data['selling_price'] = $product->selling_price;
    	$data['sub_total'] = $product->selling_price;

    	DB::table('pengadaans')->insert($data);

        return response()->json($data);
    	}

    	
 
    }


  public function PengadaanDetail(){
   $pengadaan = DB::table('pengadaans')->get();
  	return response()->json($pengadaan);
  }



 public function removePengadaan($id){
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


}
