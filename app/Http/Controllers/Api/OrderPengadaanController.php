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
        // $orderpengadaan = DB::table('order_pengadaans')->where('id',$id)->first();
        // return response()->json($orderpengadaan);
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
            'nama_gudang' => 'required',
            'supplier' => 'required',
            'status_pengadaan' => 'required',
        ]);
        
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
            
            // DB::table('order_pengadaans')->insert($data);
            //pembatas
            $order_id = DB::table('order_pengadaans')->insertGetId($data);

            $contents = DB::table('pengadaans')->get();

            $odata = array();
            foreach ($contents as $content) {
            $odata['order_id'] = $order_id;
            $odata['product_name'] = $content->product_name;
            $odata['product_id'] = $content->productid_pengadaan;
            $odata['pro_quantity'] = $content->product_quantity;
            $odata['product_price'] = $content->selling_price;
            $odata['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($odata); 

            
                DB::table('products')
                    ->where('id',$content->productid_pengadaan)
                    ->update(['product_quantity' => DB::raw('product_quantity -' .$content->product_quantity)]);

            }
            DB::table('pengadaans')->delete();
            return response('Done');
            //pembatas


        }else{
            $data = array();
            $data['pengadaan_id'] = $request->pengadaan_id;
            $data['nama_gudang'] = $request->nama_gudang;
            $data['supplier'] = $request->supplier;
            $data['status_pengadaan'] = $request->status_pengadaan;
            
            // DB::table('order_pengadaans')->insert($data);
   
            //pembatas
            $order_id = DB::table('order_pengadaans')->insertGetId($data);

            $contents = DB::table('pengadaans')->get();

            $odata = array();
            foreach ($contents as $content) {
            $odata['order_id'] = $order_id;
            $odata['product_name'] = $content->product_name;
            $odata['product_id'] = $content->productid_pengadaan;
            $odata['pro_quantity'] = $content->product_quantity;
            $odata['product_price'] = $content->selling_price;
            $odata['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($odata); 

            
                DB::table('products')
                    ->where('id',$content->productid_pengadaan)
                    ->update(['product_quantity' => DB::raw('product_quantity -' .$content->product_quantity)]);

            }
            DB::table('pengadaans')->delete();
            return response('Done');
        }
    }
}
