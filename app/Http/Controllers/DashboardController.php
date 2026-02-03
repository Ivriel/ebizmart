<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Stuff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->role !== 'owner') {
            return redirect()->route('productList.index');
        }

        $hour = now()->format('H');
        $greeting = match (true) {
            $hour < 11 => 'Selamat Pagi',
            $hour < 15 => 'Selamat Siang',
            $hour < 18 => 'Selamat Sore',
            default => 'Selamat Malam'
        };

        $data = [
            'greeting' => $greeting,
            'total_barang' => Stuff::count(),
            'stok_tipis' => Stuff::where('stok_barang', '<', 5)->count(),
            'total_user' => User::count(),
            'barang_terbaru' => Stuff::latest()->take(5)->get(),
            'transaksi_terbaru' => Sale::latest()->take(5)->get(),
            'total_transaksi' => Sale::count(),
            'total_penjualan' => Sale::sum('total'),
            'total_metode_pembayaran' => Payment::count(),
            'total_metode_pembayaran_aktif' => Payment::where('is_active', '=', 1)->count(),
            'total_metode_pembayaran_nonaktif' => Payment::where('is_active', '=', 0)->count(),
        ];

        return view('dashboard', $data);

    }
}
