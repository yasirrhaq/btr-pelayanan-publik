<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use App\Models\StatusLayanan;
use App\Models\UserStatusLayanan;

class StatusLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.status-layanan.index', ['statusLayanan' => UserStatusLayanan::with(['user:id,name,email', 'status:id,name', 'jenis:id,name'])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.status-layanan.create', ['statusLayanan' => StatusLayanan::all(), 'jenisLayanan' => JenisLayanan::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users',
            'layanan_id' => 'required',
            'status_id' => 'required',
            'detail' => 'required'
        ]);

        $user = User::where(['email' => $request->email])->first()->id;
        $validatedData['user_id'] = $user;

        UserStatusLayanan::create($validatedData);
        return redirect('/dashboard/status-layanan')->with('success', 'Status Layanan berhasil ditambahkan!');
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
        return view('dashboard.status-layanan.edit', [
            'status' => StatusLayanan::all(),
            'statusLayanan' => UserStatusLayanan::with(['user:id,name,email', 'status:id,name'])->find($id)
        ]);
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
        $rules = [
            'email' => 'required|email|exists:users',
            'status_id' => 'required',
            'detail' => 'required'
        ];

        $validatedData = $request->validate($rules);
        unset($validatedData['email']);
        $user = User::where(['email' => $request->email])->first()->id;
        $validatedData['user_id'] = $user;
        $validatedData['status_id'] = $request->status_id;
        $validatedData['detail'] = $request->detail;
        UserStatusLayanan::where('id',$id)->update($validatedData);
        
        return redirect('/dashboard/status-layanan')->with('success', 'Status Layanan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserStatusLayanan::where('id', $id)->delete($id);
        return back()->with('success', 'Status Layanan berhasil dihapus!');
    }
}
