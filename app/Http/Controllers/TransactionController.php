<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public $transaksi;

    public function showTransaksi(Transaction $transaction){
        $users = User::all();
        $data = Transaction::latest()->paginate(20);
        // dd($users);
        return view("pages.transaksi", compact('data', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required',
            'keterangan' => 'required',
            'jenis_transaksi' => 'required'
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'jenis_transaksi' => $request->jenis_transaksi,
            'tanggal_transaksi' => Carbon::today()->toDateString(),
        ]);
        $transaction->user->givePermissionTo('hapus-transaksi');

        return redirect()->back()->with('success', 'Data transaksi '. $request->jenis_transaksi .' berhasil ditambahkan');
    }

    public function destroy($id)
    {        
        $transaction = Transaction::findOrFail($id);

        $this->authorize('delete', $transaction);
        //menghapus produk
        $transaction->delete();
        // redirect
        return redirect()->back()->with('success', 'Data berhasil dihapus');        
    }

    public function export(Request $request){
        $tipe_transaksi = $request->jenis_transaksi;
        $tanggal_transaksi_start = $request->start;
        $tanggal_transaksi_end = $request->end;

        if(isset($request->jenis_transaksi)){
            if(isset($request->user)){
                $this->transaksi = Transaction::where('user_id', $request->user)->where('jenis_transaksi', $request->jenis_transaksi)->whereBetween('tanggal_transaksi', [$request->start, $request->end])->get();
            } else {
                $this->transaksi = Transaction::whereBetween('tanggal_transaksi', [$request->start, $request->end])->where('jenis_transaksi', $request->jenis_transaksi)->get();
            }
        } else{
            if(isset($request->user)){
                $this->transaksi = Transaction::where('user_id', $request->user)->whereBetween('tanggal_transaksi', [$request->start, $request->end])->get();
                $transaksi = $this->transaksi;
                $nama_user = User::findOrFail($request->user)->name;
                $pdf = Pdf::loadview('export.all_transaction_pdf', compact('transaksi', 'tipe_transaksi', 'nama_user', 'tanggal_transaksi_start', 'tanggal_transaksi_end'));
                return $pdf->download('laporan-pegawai-pdf.pdf');
            } else {
                // dd('test_transaksi');
                $nama_user = 'semua User';
                $this->transaksi = Transaction::whereBetween('tanggal_transaksi', [$request->start, $request->end])->get();
                $transaksi = $this->transaksi;
                $pdf = Pdf::loadview('export.all_transaction_pdf', compact('transaksi', 'tipe_transaksi', 'nama_user', 'tanggal_transaksi_start', 'tanggal_transaksi_end'));
                return $pdf->download('laporan-pegawai-pdf.pdf');
            }
        }
        $total = $this->transaksi->sum('nominal');
        $nama_user = User::findOrFail($request->user)->name;
        $transaksi = $this->transaksi;

        $pdf = Pdf::loadview('export.transaction_pdf', compact('transaksi', 'tipe_transaksi', 'nama_user', 'total', 'tanggal_transaksi_start', 'tanggal_transaksi_end'));
        return $pdf->download('laporan-pegawai-pdf.pdf');
    }

    public function showApi(Request $request){
        $request->validate([
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required'
        ]);

        $data = Transaction::whereBetween('tanggal_transaksi', [$request->tanggal_awal, $request->tanggal_akhir])->get();
        if ($data === NULL){
            return response()->json('data yang dipilik tidak ada atau kosong.');
        } else {
            return response()->json(['data' => $data]);

        }

    }
}
