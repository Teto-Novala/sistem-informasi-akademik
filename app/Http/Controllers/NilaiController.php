<?php

namespace App\Http\Controllers;

use App\Exports\NilaiExport;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data= Nilai::with(['mahasiswa','dosen','matakuliah'])->get();
        return Inertia::render('Nilai/Index',[
            'data'=> $data,
            
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        $mahasiswa= Mahasiswa::all();
        $dosen= Dosen::all();
        $matakuliah=MataKuliah::all();
        return Inertia::render('Nilai/Create',[
            'mahasiswa'=>$mahasiswa,
            'dosen'=>$dosen,
            'matakuliah'=>$matakuliah
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id'=>'required',
            'dosen_id'=>'required',
            'matakuliah_id'=>'required',
            'nilai_huruf'=>'required',
            'nilai_angka'=>'required',
        ]);

        Nilai::create($request->all());

        return redirect()->route('nilai.index')->with('success','Nilai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        $mahasiswa= Mahasiswa::all();
        $dosen= Dosen::all();
        $matakuliah=MataKuliah::all();
        return Inertia::render('Nilai/Edit', [
            'data' => $nilai,
            'mahasiswa'=>$mahasiswa,
            'dosen'=>$dosen,
            'matakuliah'=>$matakuliah
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
        'mahasiswa_id' => 'required',
        'dosen_id' => 'required',
        'matakuliah_id' => 'required',
        'nilai_angka' => 'required|numeric', // Pastikan angka
        'nilai_huruf' => 'required',
    ]);

    // 2. Update data nilai
    $nilai->update($request->all());

    // 3. Redirect kembali ke halaman Index Nilai
    return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'berhasil menghapus nilai'
        ]);
    }

    public function exportPDF(){
        $nilai = Nilai::with(['mahasiswa','dosen','matakuliah'])->get();
        $pdf = Pdf::loadView('nilai.pdf',compact('nilai'));
        return $pdf->download('data-nilai.pdf');
    }
    public function exportExcel(){
        return Excel::download(new NilaiExport,'data-nilai.xlsx');
    }
}
