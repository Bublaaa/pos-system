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
        $user = Auth::user();
        $today = now()->format('Y-m-d');

        // Check if the user has already made 2 entries for today
        $entriesToday = Attendance::where('name', $user->name)
            ->whereDate('created_at', $today)
            ->count();

        if ($entriesToday > 1) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini.');
        }
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
        }
    }
}