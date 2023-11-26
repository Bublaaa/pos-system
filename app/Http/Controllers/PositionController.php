<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $positions = Position::get();
        return view('../layouts/contents/editPosition')->with(['positions' => $positions]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'addName' => 'string|max:255',
            'addBasicSalary' => ['required', 'integer', 'min:1'],
        ]);
        $positionName = strtolower(str_replace(' ', '', $request->addName));
        $position = Position::where('name',$positionName)->get();
        
        if($position->count()>0){
            return redirect()->back()->with('error', 'Posisi sudah terdaftar');
        }
        $newPosition = Position::create([  
            'name' => $positionName,
            'basic_salary' => $request->addBasicSalary,
        ]);
        if (!$newPosition) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan posisi.');
        }
        else{
            return redirect()->back()->with('success', 'Tambah posisi sukses');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {   
        $users = User::where('position', $position->name)->get();
        if($position->name == 'owner' || $position->name == 'employee'){
            return redirect()->back()->with('error', 'Posisi owner dan karyawan tidak bisa dihapus.');
        }
        else{
            foreach($users as $user){
                $user->position = 'employee';
                $user->save();
            }
        }
        $position->delete();
        return redirect()->back()->with('success', 'Sukses hapus posisi.');
    }
}