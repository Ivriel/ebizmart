<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSaleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $sales = Sale::with(['user', 'payment', 'detailTransactions.stuff'])
            ->when($status, function ($query, $status) {
                return $query->where('status_transaksi', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.sales.index', compact('sales', 'status'));
    }

    public function show($id)
    {
        $sale = Sale::with(['user', 'payment', 'detailTransactions.stuff'])->findOrFail($id);

        return view('admin.sales.show', compact('sale'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status_transaksi' => 'required|in:Belum Bayar,Dalam Proses,Selesai,Gagal',
        ]);

        $sale = Sale::with('detailTransactions.stuff')->findOrFail($id);
        $oldStatus = $sale->status_transaksi;
        $newStatus = $validated['status_transaksi'];

        // kalau status ga berubah gausah proses
        if ($oldStatus === $newStatus) {
            return back()->with('info', 'Status tidak berubah.');
        }

        DB::beginTransaction();
        try {
            // Update status transaksi
            $sale->update(['status_transaksi' => $newStatus]);

            // LOGIKA PENGURANGAN STOK
            // kalau status diubah jadi 'Selesai', kurangi stok
            if ($oldStatus !== 'Selesai' && $newStatus === 'Selesai') {
                foreach ($sale->detailTransactions as $detail) {
                    $stuff = $detail->stuff;

                    // Validasi stok mencukupi
                    if ($stuff->stok_barang < $detail->jumlah) {
                        DB::rollBack();

                        return back()->with('error', "Stok {$stuff->nama_barang} tidak mencukupi! Stok tersedia: {$stuff->stok_barang}, dibutuhkan: {$detail->jumlah}");
                    }

                    $stuff->decrement('stok_barang', $detail->jumlah);

                    $stuff->refresh();
                    if ($stuff->stok_barang == 0) {
                        $stuff->update(['status_ketersediaan' => 'Habis']);
                    }
                }
            }

            if ($oldStatus === 'Selesai' && $newStatus !== 'Selesai') {
                foreach ($sale->detailTransactions as $detail) {
                    $stuff = $detail->stuff;

                    // Kembalikan stok
                    $stuff->increment('stok_barang', $detail->jumlah);

                    if ($stuff->stok_barang > 0) {
                        $stuff->update(['status_ketersediaan' => 'Tersedia']);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.sales.index')->with('success', "Status transaksi berhasil diubah dari '{$oldStatus}' ke '{$newStatus}'!");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal mengubah status transaksi: '.$e->getMessage());
        }
    }
}
