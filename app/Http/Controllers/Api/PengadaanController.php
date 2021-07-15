<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Pengadaan;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $pengadaan = DB::table('pengadaans')
        // ->join('products','pengadaans.product_id','products.product_code')
        // ->select('products.category_name','suppliers.name','products.*')
        // ->orderBy('products.id','DESC')
        // ->get();
        // return response()->json($pengadaan);

        // $pengadaan = DB::table('products')
        // ->join('products','pengadaans.product_id','products.product_code')
        // ->select('products.category_name','suppliers.name','products.*')
        // ->orderBy('products.id','DESC')
        // ->get();
        // return response()->json($pengadaan);
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
        $pengadaan = DB::table('products')->where('id',$id)->first();
        return response()->json($pengadaan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    //detail pengadaan
    public function AddToDetail(Request $request, $id){
    	$product = DB::table('products')->where('id',$id)->first();

    	$check = DB::table('pengadaans')->where('product_code',$id)->first();

    	if ($check) {
    	DB::table('pengadaans')->where('product_code',$id)->increment('product_quantity');

       $product = DB::table('pengadaans')->where('product_code',$id)->first();
  	   $subtotal = $product->product_quantity * $product->selling_price;
  	   DB::table('pengadaans')->where('product_code',$id)->update(['sub_total'=> $subtotal]);

    	}else{
    	$data = array();
    	// $data['pro_id'] = $id;
    	$data['product_code'] = $id;
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
}
