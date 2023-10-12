<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceStoreRequest;


class AttendanceController extends Controller
{
    public function index()
    {
        return view('../layouts/contents/employeeAttendance');
    }
    public function store(Request $request)
    {
        $image_path = '';
        $name = Auth::user()->name;
        // if ($request->hasFile('image')) {
        //     $image_path = $request->file('image')->store('attendanceImages', 'public');
        // }
        $attendance = Attendance::create([  
            'name' => $name,
            'description' => $request->description,
            'image' => $image_path,
            'status' => $request->status,
            'latitude' =>$request->latitude,
            'longitude' =>$request->longitude,
        ]);
        dd($attendance);

        // if (!$attendance) {
        //     return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan absensi.');
        // }
        // if(Auth::user()->position == 'headbar'){
        //     return redirect()->route('headbar.dashboard')->with('success', 'Absen sukses');
        // }
        
    }
}