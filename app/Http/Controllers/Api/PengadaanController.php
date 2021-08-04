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
        $pengadaan = Pengadaan::all();
        return response()->json($pengadaan);

        // $pengadaan = DB::table('pengadaans')
        // // ->join('categories','products.category_id','categories.id')
        // ->join('suppliers','pengadaans.supplier_id','suppliers.id')
        // ->select('suppliers.name','pengadaans.*')
        // ->orderBy('pengadaans.id','DESC')
        // ->get();
        // return response()->json($pengadaan);
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
        $validateData = $request->validate([
        ]);
   
        $datap = array();
        $datap['supplierid_pengadaan'] = $request->supplierid_pengadaan;
        $datap['supplier_name'] = $request->supplier_name;
        $datap['gudangid_pengadaan'] = $request->gudangid_pengadaan;
        $datap['nama_gudang'] = $request->nama_gudang;
        $datap['status_pengadaan'] = $request->status_pengadaan;
        $datap['document'] = $request->document;
        
        DB::table('pengadaans')->insert($datap);
        // $donep = DB::table('pengadaans')->insertGetId($datap);
            
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
        $pengadaan = DB::table('pengadaans')->where('id',$id)->first();
        return response()->json($pengadaan);
    //     $employee = DB::table('employees')->where('id',$id)->first();
    //    return response()->json($employee);
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
}
