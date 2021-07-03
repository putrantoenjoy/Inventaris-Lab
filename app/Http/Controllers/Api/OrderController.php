<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
  // public function TambahPengadaan(){
    
  //   $data = date('d/m/Y');
  //   $order = DB::table('orders')
  //     ->join('customers','orders.customer_id','customers.id')
  //     ->where('order_date',$data)
  //     ->select('customers.name','orders.*')
  //     ->orderBy('orders.id','DESC')->get();
  //     return response()->json($order); 
  // }
  
  // public function TambahPengadaan(){
  //   //$pagename = 'TAMBAH PENGADAAN';
  //   $data = date('d/m/Y');
  //   $pengadaan = Pengadaan::all();
  //   return response()->json($pengadaan, $penga);
  // }



  public function store(Request $request){
    if ($request->image) {
      $position = strpos($request->image, ';');
      $sub = substr($request->image, 0, $position);
      $ext = explode('/', $sub)[1];

      $name = time().".".$ext;
      $img = Image::make($request->image)->resize(240,200);
      $upload_path = 'backend/pengadaan/';
      $image_url = $upload_path.$name;
      $img->save($image_url);

      $pengadaan = new Product;
      // $pengadaan->category_id = $request->category_id;
      // $pengadaan->product_name = $request->product_name;
      // $pengadaan->product_code = $request->product_code;
      // $pengadaan->root = $request->root;
      // $pengadaan->buying_price = $request->buying_price;
      // $pengadaan->selling_price = $request->selling_price;
      // $pengadaan->supplier_id = $request->supplier_id;
      // $pengadaan->buying_date = $request->buying_date;
      // $pengadaan->product_quantity = $request->product_quantity;
      $pengadaan->image = $image_url;
      $pengadaan->save(); 
  }else{
     $pengadaan = new Product;
      // $pengadaan->category_id = $request->category_id;
      // $pengadaan->product_name = $request->product_name;
      // $pengadaan->product_code = $request->product_code;
      // $pengadaan->root = $request->root;
      // $pengadaan->buying_price = $request->buying_price;
      // $pengadaan->selling_price = $request->selling_price;
      // $pengadaan->supplier_id = $request->supplier_id;
      // $pengadaan->buying_date = $request->buying_date;
      // $pengadaan->product_quantity = $request->product_quantity;
      
      $pengadaan->save(); 

  }

  }
  public function TodayOrder(){
    
    $data = date('d/m/Y');
    $order = DB::table('orders')
      ->join('customers','orders.customer_id','customers.id')
      ->where('order_date',$data)
      ->select('customers.name','orders.*');
      return response()->json($order); 
  }


   public function OrderDetails($id){
   	//return response()->json($id);
   	$order = DB::table('orders')
   	  ->join('customers','orders.customer_id','customers.id')
   	  ->where('orders.id',$id)
   	  ->select('customers.name','customers.phone','customers.address','orders.*')
   	  ->first();
   	  return response()->json($order);

   }


   public function OrderDetailsAll($id){

   		$details = DB::table('order_details')
   			->join('products','order_details.product_id','products.id')
   			->where('order_details.order_id',$id)
   			->select('products.product_name','products.product_code','products.image','order_details.*')
   			->get();
   			return response()->json($details);


   }



}
