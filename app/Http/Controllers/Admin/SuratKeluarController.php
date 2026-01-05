<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratKeluar::with('suratMasuk');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('tujuan_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        // Filter by sifat
        if ($request->has('sifat') && $request->sifat != '') {
            $query->where('sifat', $request->sifat);
        }

        $suratKeluar = $query->orderBy('tanggal_surat', 'desc')
                            ->paginate(10);

        return view('admin.surat-keluar.index', compact('suratKeluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get surat masuk untuk option balasan
        $suratMasuk = SuratMasuk::orderBy('nomor_surat', 'desc')->get();
        return view('admin.surat-keluar.create', compact('suratMasuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|unique:surat_keluar,nomor_surat|max:255',
            'tujuan_surat' => 'required|max:255',
            'tanggal_surat' => 'required|date',
            'sifat' => 'required|in:Sangat Segera,Segera,Rahasia',
            'perihal' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
            'surat_masuk_id' => 'nullable|exists:surat_masuk,id',
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi',
            'nomor_surat.unique' => 'Nomor surat sudah digunakan',
            'tujuan_surat.required' => 'Tujuan surat wajib diisi',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'sifat.required' => 'Sifat surat wajib dipilih',
            'perihal.required' => 'Perihal wajib diisi',
            'file_surat.mimes' => 'File harus berformat PDF',
            'file_surat.max' => 'Ukuran file maksimal 2MB',
            'surat_masuk_id.exists' => 'Surat masuk tidak valid',
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-keluar', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        SuratKeluar::create($validated);

        return redirect()->route('admin.surat-keluar.index')
                        ->with('success', 'Surat keluar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        $suratKeluar->load('suratMasuk');
        return view('admin.surat-keluar.show', compact('suratKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $suratMasuk = SuratMasuk::orderBy('nomor_surat', 'desc')->get();
        return view('admin.surat-keluar.edit', compact('suratKeluar', 'suratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|max:255|unique:surat_keluar,nomor_surat,' . $suratKeluar->id,
            'tujuan_surat' => 'required|max:255',
            'tanggal_surat' => 'required|date',
            'sifat' => 'required|in:Sangat Segera,Segera,Rahasia',
            'perihal' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
            'surat_masuk_id' => 'nullable|exists:surat_masuk,id',
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi',
            'nomor_surat.unique' => 'Nomor surat sudah digunakan',
            'tujuan_surat.required' => 'Tujuan surat wajib diisi',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'sifat.required' => 'Sifat surat wajib dipilih',
            'perihal.required' => 'Perihal wajib diisi',
            'file_surat.mimes' => 'File harus berformat PDF',
            'file_surat.max' => 'Ukuran file maksimal 2MB',
            'surat_masuk_id.exists' => 'Surat masuk tidak valid',
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($suratKeluar->file_surat) {
                Storage::disk('public')->delete($suratKeluar->file_surat);
            }

            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-keluar', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        $suratKeluar->update($validated);

        return redirect()->route('admin.surat-keluar.index')
                        ->with('success', 'Surat keluar berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        // Delete file if exists
        if ($suratKeluar->file_surat) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }

        $suratKeluar->delete();

        return redirect()->route('admin.surat-keluar.index')
                        ->with('success', 'Surat keluar berhasil dihapus!');
    }

    /**
     * Print surat keluar
     */
    public function print(SuratKeluar $suratKeluar)
    {
        return view('admin.surat-keluar.print', compact('suratKeluar'));
    }
}