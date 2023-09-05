<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.   
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        // dd($users);
        return view('pages.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if(User::where('username', $request->username)->exists()){
            // dd('data ada');
            return redirect()->route('users.index')->with('error', 'Username sudah terdaftar');
        } else{
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
                'level' => 'required'
            ]);

            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'password' => $request->password,
            ]);
            $user->assignRole($request->level);
        }




        // kembalikan kepada tampilan index
        // $error = session()->get('errors');
        // // dd($error);
        // if($error->any()){
        //     return redirect()->route('users.index')->with('error', 'Username Sudah terdaftar');
        // } else {
            
        // }
        return redirect()->route('users.index')->with('success', 'Data berhasil ditambahkan');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'level' => 'required'
        ]);
        // dd($request->username);
        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password,
        ]);
        $user->assignRole($request->level);
        return redirect()->route('users.index')->with('success', 'Data berhasil diupdate');        
    }

    /**
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //menghapus produk
        $user->delete();
        // redirect
        return redirect()->route('users.index')->with('success', 'Data berhasil dihapus');        
    }
}
