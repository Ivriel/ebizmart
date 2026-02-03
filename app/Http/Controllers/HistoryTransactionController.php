<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Sale;
use Illuminate\Http\Request;

class HistoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->guard()->user();
        $status = $request->get('status');
        if ($user->role === 'pelanggan') {
            $sales = Sale::with(['payment', 'user'])->where('user_id', $user->id)
                ->when($status, function ($query, $status) {
                    return $query->where('status_transaksi', $status);
                })
                ->latest()->paginate(10);
        } else {
            $sales = Sale::with(['payment', 'user'])
                ->when($status, function ($query, $status) {
                    return $query->where('status_transaksi', $status);
                })
                ->latest()->paginate(10);
        }

        return view('history.index', [
            'sales' => $sales,
        ]);
    }

    public function detail($id)
    {
        $transaction = Sale::with(['payment', 'user'])->findOrFail($id);
        $detailTransaction = DetailTransaction::where('sale_id', $id)->get();

        return view('history.show', [
            'transaction' => $transaction,
            'detailTransaction' => $detailTransaction,
        ]);
    }
}
