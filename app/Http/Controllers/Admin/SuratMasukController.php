<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('surat_dari', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('no_agenda', 'like', "%{$search}%");
            });
        }

        // Filter by sifat
        if ($request->has('sifat') && $request->sifat != '') {
            $query->where('sifat', $request->sifat);
        }

        $suratMasuk = $query->orderBy('diterima_tanggal', 'desc')
                            ->paginate(10);

        return view('admin.surat-masuk.index', compact('suratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: lihat semua data yang dikirim
        // dd($request->all());

        $validated = $request->validate([
            'nomor_surat' => 'required|unique:surat_masuk,nomor_surat|max:255',
            'surat_dari' => 'required|max:255',
            'tanggal_surat' => 'required|date',
            'diterima_tanggal' => 'required|date',
            'no_agenda' => 'required|unique:surat_masuk,no_agenda|max:255',
            'sifat' => 'required|in:Sangat Segera,Segera,Rahasia',
            'perihal' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048', // Max 2MB
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi',
            'nomor_surat.unique' => 'Nomor surat sudah digunakan',
            'surat_dari.required' => 'Surat dari wajib diisi',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'diterima_tanggal.required' => 'Tanggal diterima wajib diisi',
            'no_agenda.required' => 'No agenda wajib diisi',
            'no_agenda.unique' => 'No agenda sudah digunakan',
            'sifat.required' => 'Sifat surat wajib dipilih',
            'perihal.required' => 'Perihal wajib diisi',
            'file_surat.mimes' => 'File harus berformat PDF',
            'file_surat.max' => 'Ukuran file maksimal 2MB',
        ]);

        // Debug: lihat data setelah validasi
        // dd($validated);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-masuk', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        // Debug: lihat data sebelum create
        // dd($validated);

        $surat = SuratMasuk::create($validated);

        // Debug: lihat data setelah create
        // dd($surat);

        return redirect()->route('admin.surat-masuk.index')
                        ->with('success', 'Surat masuk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('disposisi.user');
        return view('admin.surat-masuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('admin.surat-masuk.edit', compact('suratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|max:255|unique:surat_masuk,nomor_surat,' . $suratMasuk->id,
            'surat_dari' => 'required|max:255',
            'tanggal_surat' => 'required|date',
            'diterima_tanggal' => 'required|date',
            'no_agenda' => 'required|max:255|unique:surat_masuk,no_agenda,' . $suratMasuk->id,
            'sifat' => 'required|in:Sangat Segera,Segera,Rahasia',
            'perihal' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi',
            'nomor_surat.unique' => 'Nomor surat sudah digunakan',
            'surat_dari.required' => 'Surat dari wajib diisi',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi',
            'diterima_tanggal.required' => 'Tanggal diterima wajib diisi',
            'no_agenda.required' => 'No agenda wajib diisi',
            'no_agenda.unique' => 'No agenda sudah digunakan',
            'sifat.required' => 'Sifat surat wajib dipilih',
            'perihal.required' => 'Perihal wajib diisi',
            'file_surat.mimes' => 'File harus berformat PDF',
            'file_surat.max' => 'Ukuran file maksimal 2MB',
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($suratMasuk->file_surat) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }

            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-masuk', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        $suratMasuk->update($validated);

        return redirect()->route('admin.surat-masuk.index')
                        ->with('success', 'Surat masuk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        // Delete file if exists
        if ($suratMasuk->file_surat) {
            Storage::disk('public')->delete($suratMasuk->file_surat);
        }

        $suratMasuk->delete();

        return redirect()->route('admin.surat-masuk.index')
                        ->with('success', 'Surat masuk berhasil dihapus!');
    }

    /**
     * Print surat masuk
     */
    public function print(SuratMasuk $suratMasuk)
    {
        return view('admin.surat-masuk.print', compact('suratMasuk'));
    }
}