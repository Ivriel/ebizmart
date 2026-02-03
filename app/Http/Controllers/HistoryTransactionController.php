<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Sale;

class HistoryTransactionController extends Controller
{
    public function index()
    {
        $user = auth()->guard()->user();
        if ($user->role === 'pelanggan') {
            $sales = Sale::with(['payment', 'user'])->where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $sales = Sale::with(['payment', 'user'])->latest()->paginate(10);
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
