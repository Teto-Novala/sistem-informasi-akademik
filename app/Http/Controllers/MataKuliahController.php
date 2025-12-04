<?php

namespace App\Http\Controllers;

use App\Exports\MataKuliahExport;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Inertia::render('MataKuliah/Index',[
            'data'=> MataKuliah::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MataKuliah/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'kode_mk'=>'required|unique:matakuliah',
            'sks'=>'required'
        ]);

        MataKuliah::create($request->all());

        return redirect()->route('matakuliah.index')->with('success','Mata Kuliah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $matakuliah)
    {
        return Inertia::render('MataKuliah/Edit', [
            'data' => $matakuliah
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $matakuliah)
    {
        $request->validate([
            'nama' => 'required',
            'kode_mk' => 'required|unique:matakuliah,kode_mk,' . $matakuliah->id, 
            'sks' => 'required'
        ]);

        $matakuliah->update($request->all());

        return redirect()->route('matakuliah.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'berhasil menghapus mata kuliah'
        ]);
    }

     public function exportExcel(){
        return Excel::download(new MataKuliahExport,'data-matakuliah.xlsx');
    }

    public function exportPDF(){
        $matakuliah = MataKuliah::all();
        $pdf = Pdf::loadView('matakuliah.pdf',compact('matakuliah'));
        return $pdf->download('data-matakuliah.pdf');
    }
}
