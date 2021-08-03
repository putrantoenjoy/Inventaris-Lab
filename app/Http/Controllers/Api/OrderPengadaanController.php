<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\OrderPengadaan;
use DB;
use Image;

class OrderPengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $pengadaan = OrderPengadaan::all();
        // return response()->json($pengadaan);

        $pengadaan = DB::table('order_pengadaans')->orderBy('id','DESC')->get();
        return response()->json($pengadaan);
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
        $orderpengadaan = DB::table('order_pengadaans')->where('id',$id)->first();
        return response()->json($orderpengadaan);
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
        // $data = array();
        // $data[''] = $request->name;
        // $data['email'] = $request->email;
        // $data['phone'] = $request->phone;
        // $data['address'] = $request->address;
        // $image = $request->newphoto;

        $data = array();
        $data['pengadaan_id'] = $request->pengadaan_id;
        $data['nama_gudang'] = $request->nama_gudang;
        $data['supplier'] = $request->supplier;
        $data['status_pengadaan'] = $request->status_pengadaan;
        $image = $request->newphoto;

        if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $ext = explode('/', $sub)[1];

         $name = time().".".$ext;
         $img = Image::make($image)->resize(240,200);
         $upload_path = 'backend/pengadaan/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);
         
         if ($success) {
            $data['photo'] = $image_url;
            $img = DB::table('order_pengadaans')->where('id',$id)->first();
            $image_path = $img->photo;
            $done = unlink($image_path);
            $user  = DB::table('order_pengadaans')->where('id',$id)->update($data);
         }
          
        }else{
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('order_pengadaans')->where('id',$id)->update($data);
        }
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
        $orderpengadaan = DB::table('order_pengadaans')->where('id',$id)->first();
        $photo = $orderpengadaan->photo;
        if ($photo) {
            unlink($photo);
            DB::table('order_pengadaans')->where('id',$id)->delete();
        }else{
            DB::table('order_pengadaans')->where('id',$id)->delete();
        }
    }
    public function pengadaanInsert(Request $request)
    {
        //
        $validateData = $request->validate([
        ]);
        
        //benar
        // $data = array();
        // $data['pengadaan_id'] = $request->pengadaan_id;
        // $data['nama_gudang'] = $request->nama_gudang;
        // $data['supplier'] = $request->supplier;
        // $data['status_pengadaan'] = $request->status_pengadaan;
        // $data['document'] = $request->document;
        
        // DB::table('order_pengadaans')->insert($data);
        
        
        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];
   
            $name = time().".".$ext;
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/pengadaan/';
            $image_url = $upload_path.$name;
            $img->save($image_url);
    
            $data = array();
            $data['pengadaan_id'] = $request->pengadaan_id;
            $data['nama_gudang'] = $request->nama_gudang;
            $data['supplier'] = $request->supplier;
            $data['status_pengadaan'] = $request->status_pengadaan;
            $data['photo'] = $image_url;
            
            DB::table('order_pengadaans')->insert($data);
        }else{
            $data = array();
            $data['pengadaan_id'] = $request->pengadaan_id;
            $data['nama_gudang'] = $request->nama_gudang;
            $data['supplier'] = $request->supplier;
            $data['status_pengadaan'] = $request->status_pengadaan;
            
            DB::table('order_pengadaans')->insert($data);
   
        }

        //document
        // if ($request->document) {
        //     $position = strpos($request->document, ';');
        //     $sub = substr($request->document, 0, $position);
        //     $ext = explode('/', $sub)[1];
   
        //     $name = time().".".$ext;
        //     $img = Image::make($request->document)->resize(240,200);
        //     $upload_path = 'backend/orderpengadaan/';
        //     $document_url = $upload_path.$name;
        //     $img->save($document_url);
   
        //     $orderpengadaan = new OrderPengadaan;
        //     $orderpengadaan->pengadaan_id = $request->pengadaan_id;
        //     $orderpengadaan->nama_gudang = $request->nama_gudang;
        //     $orderpengadaan->supplier = $request->supplier;
        //     $orderpengadaan->status_pengadaan = $request->status_pengadaan;
        //     $orderpengadaan->document = $document_url;
            
        //     $orderpengadaan->save(); 
        // }else{
        //     $orderpengadaan = new OrderPengadaan;
        //     $orderpengadaan->pengadaan_id = $request->pengadaan_id;
        //     $orderpengadaan->nama_gudang = $request->nama_gudang;
        //     $orderpengadaan->supplier = $request->supplier;
        //     $orderpengadaan->status_pengadaan = $request->status_pengadaan;
            
        //     $orderpengadaan->save(); 
   
        // }


        //pembatas
        // $contents = DB::table('pengadaans')->get();

        // $data2 = array();
        // foreach ($contents as $content) {
        // $data2['order_id'] = $order_id;
        // $data2['product_id'] = $content->pro_id;
        // $data2['pro_quantity'] = $content->pro_quantity;
        // $data2['product_price'] = $content->product_price;
        // $data2['sub_total'] = $content->sub_total;
        // DB::table('order_details')->insert($data2); 

        
        //     DB::table('products')
        //         ->where('id',$content->pro_id)
        //         ->update(['product_quantity' => DB::raw('product_quantity -' .$content->pro_quantity)]);

        // }
        // DB::table('pos')->delete();
        // return response('Done');
    }
}
