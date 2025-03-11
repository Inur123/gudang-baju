<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $nameParts = explode(' ', $user->name); // Pisahkan nama berdasarkan spasi
        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

        $totalClothes = Clothes::count(); // Menghitung total pakaian dalam database

        return view('dashboard.index', compact('user', 'initials', 'totalClothes'));
    }
}
