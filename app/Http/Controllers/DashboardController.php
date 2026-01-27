<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $hour = now()->format('H');
        $greeting = match (true) {
            $hour < 11 => 'Selamat Pagi',
            $hour < 15 => 'Selamat Siang',
            $hour < 18 => 'Selamat Sore',
            default => 'Selamat Malam'
        };

        return view('dashboard', [
            'greeting' => $greeting,
        ]);
    }
}
