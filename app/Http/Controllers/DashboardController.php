<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard(){
        $pemasukan_hari_ini = Transaction::where('jenis_transaksi', 'pemasukan')->whereDay('tanggal_transaksi', Carbon::today())->sum('nominal');
        $pemasukan_bulan_ini = Transaction::where('jenis_transaksi', 'pemasukan')->whereMonth('tanggal_transaksi', Carbon::now()->month)->sum('nominal');

        $pengeluaran_hari_ini = Transaction::where('jenis_transaksi', 'pengeluaran')->whereDay('tanggal_transaksi', Carbon::today())->sum('nominal');
        $pengeluaran_bulan_ini = Transaction::where('jenis_transaksi', 'pengeluaran')->whereMonth('tanggal_transaksi', Carbon::now()->month)->sum('nominal');

        $total_pemasukan = Transaction::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $total_pengeluaran = Transaction::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        
        // dd($data);
        return view("pages.dashboard", compact('pemasukan_hari_ini', 'pengeluaran_hari_ini', 'pemasukan_bulan_ini', 'pengeluaran_bulan_ini', 'total_pemasukan', 'total_pengeluaran'));
    }
}
