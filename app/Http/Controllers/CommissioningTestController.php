<?php

namespace App\Http\Controllers;

use App\Models\CommissioningTest;
use App\Models\CommissioningTestImage;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommissioningTestController extends Controller
{
    public function index(Lokasi $lokasi)
    {
        $test = $lokasi->commissioningTest()->first();
        $personelList = User::where('role', 'waspang')->orderBy('name')->get();

        return view('lokasi.partials.commissioning_test', compact('lokasi', 'test', 'personelList'));
    }

    public function store(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'personel_id' => 'required|exists:waspangs,id',
            'tanggal' => 'required|date',
            'kota_ttd' => 'required|string|max:255',
            'status_pekerjaan' => 'required|in:telah,belum',
            'status_hasil' => 'required|in:dapat,tidak_dapat',
            'status_kelayakan' => 'required|in:layak,tidak_layak',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image_labels.*' => 'nullable|string|max:255',
        ]);

        $commissioningTest = $lokasi->commissioningTest()->create([
            'personel_id' => $validated['personel_id'],
            'tanggal' => $validated['tanggal'],
            'kota_ttd' => $validated['kota_ttd'],
            'status_pekerjaan' => $validated['status_pekerjaan'],
            'status_hasil' => $validated['status_hasil'],
            'status_kelayakan' => $validated['status_kelayakan'],
        ]);

        // Handle image uploads
        $this->storeImages($request, $commissioningTest);

        return back()->with('success', 'Commissioning test berhasil ditambahkan.');
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $test = $lokasi->commissioningTest()->first();

        if (!$test) {
            return back()->with('error', 'Data commissioning test tidak ditemukan.');
        }

        $validated = $request->validate([
            'personel_id' => 'required|exists:waspangs,id',
            'tanggal' => 'required|date',
            'kota_ttd' => 'required|string|max:255',
            'status_pekerjaan' => 'required|in:telah,belum',
            'status_hasil' => 'required|in:dapat,tidak_dapat',
            'status_kelayakan' => 'required|in:layak,tidak_layak',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image_labels.*' => 'nullable|string|max:255',
        ]);

        $test->update([
            'personel_id' => $validated['personel_id'],
            'tanggal' => $validated['tanggal'],
            'kota_ttd' => $validated['kota_ttd'],
            'status_pekerjaan' => $validated['status_pekerjaan'],
            'status_hasil' => $validated['status_hasil'],
            'status_kelayakan' => $validated['status_kelayakan'],
        ]);

        // Handle image uploads
        $this->storeImages($request, $test);

        return back()->with('success', 'Commissioning test berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        $test = $lokasi->commissioningTest()->first();

        if ($test) {
            $test->delete();
        }

        return back()->with('success', 'Commissioning test berhasil dihapus.');
    }

    private function storeImages(Request $request, CommissioningTest $commissioningTest): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $images = $request->file('images');
        $labels = $request->input('image_labels', []);

        foreach ($images as $index => $image) {
            if (!$image) {
                continue;
            }

            $path = $image->store('commissioning-test-images', 'public');
            $label = $labels[$index] ?? 'Dokumentasi Commissioning Test';

            // Get next urutan
            $maxUrutan = $commissioningTest->images()->max('urutan') ?? 0;

            CommissioningTestImage::create([
                'commissioning_test_id' => $commissioningTest->id,
                'file_path' => $path,
                'label' => $label,
                'urutan' => $maxUrutan + 1,
            ]);
        }
    }
}
