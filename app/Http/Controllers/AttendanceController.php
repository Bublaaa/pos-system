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
        $request->validate([
            'status' => 'required|boolean',
            'latitude' => 'required',
            'longitude' => 'required',

        ]);
        $image_path = '';
        // Check if request has a image upload
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('attendance', 'public');
        }
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        $entriesToday = Attendance::where('name', $user->name)
            ->whereDate('created_at', $today)
            ->count();
        if ($entriesToday == 0) {
            $attendance = Attendance::create([  
                'name' => $user->name,
                'description' => $request->description,
                'image' => $image_path,
                'status' => $request->status,
                'latitude' =>$request->latitude,
                'longitude' =>$request->longitude,
            ]);
            if (!$attendance) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan absensi.');
            }
            else{
                return redirect()->back()->with('success', 'Absen sukses');
                if(!$request->latitude){
                    return redirect()->back()->with('error', 'Mohon tunggu sebentar dan ulangi absensi.');
                }
            }
        }
        else {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini.');
        }
        
    }
}