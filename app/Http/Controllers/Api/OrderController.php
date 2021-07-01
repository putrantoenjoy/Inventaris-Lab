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
  
  public function TambahPengadaan(){
    $pagename = 'TAMBAH PENGADAAn';
    $data = date('d/m/Y');
    $pengadaan = Pengadaan::all();
    return response()->json($pengadaan, $penga); 
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
