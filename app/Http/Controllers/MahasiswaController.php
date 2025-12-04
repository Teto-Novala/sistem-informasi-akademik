<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Mahasiswa/Index',[
            'data'=> Mahasiswa::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Mahasiswa/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'nim'=>'required|unique:mahasiswa',
            'jurusan'=>'required'
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')->with('success','Mahasiswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
         return Inertia::render('Mahasiswa/Edit', [
            'data' => $mahasiswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'jurusan' => 'required'
        ]);

        $mahasiswa->update($request->all());

        return redirect()->route('mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'berhasil menghapus dosen'
        ]);
    }

     public function exportExcel(){
        return Excel::download(new MahasiswaExport,'data-mahasiswa.xlsx');
    }

    public function exportPDF(){
        $mahasiswa = Mahasiswa::all();
        $pdf = Pdf::loadView('mahasiswa.pdf',compact('mahasiswa'));
        return $pdf->download('data-mahasiswa.pdf');
    }
}
