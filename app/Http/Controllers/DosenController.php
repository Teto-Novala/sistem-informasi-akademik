<?php

namespace App\Http\Controllers;

use App\Exports\DosenExport;
use App\Models\Dosen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dosen/Index', [
            'data' => Dosen::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dosen/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'nidn'=>'required|unique:dosen',
            'no_hp'=>'required',
        ]);

        Dosen::create($request->all());

        return redirect()->route('dosen.index')->with('success','Dosen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        return Inertia::render('Dosen/Edit', [
            'dataApi' => $dosen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama' => 'required',
            'nidn' => 'required',
            'no_hp' => 'required'
        ]);

        $dosen->update($request->all());

        return redirect()->route('dosen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'berhasil menghapus dosen'
        ]);
    }

    public function exportExcel(){
        return Excel::download(new DosenExport,'data-dosen.xlsx');
    }

    public function exportPDF(){
        $dosen = Dosen::all();
        $pdf = Pdf::loadView('dosen.pdf',compact('dosen'));
        return $pdf->download('data-dosen.pdf');
    }
}
