<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\AttendanceStoreRequest;


class AttendanceController extends Controller
{
    public function index()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now();
        $totalDaysInMonth = $currentMonth->daysInMonth;

        $employees = User::where('position','!=', 'owner')->get();

        $attendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $allAttendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $userAttendances = $attendanceData->groupBy('name');
        $allUserAttendance = $allAttendanceData->groupBy('name');
        
        return view('../layouts/contents/attendanceReport', [
            'employees' => $employees,
            'userAttendances' => $userAttendances,
            'totalDaysInMonth' => $totalDaysInMonth,
            'allUserAttendance' => $allUserAttendance,
        ]);
    }
    public function create(){
        return view('../layouts/contents/employeeAttendance');
    }
    public function store(Request $request){
        $request->validate([
            'status' => 'required|boolean',
            'latitude' => 'required',
            'longitude' => 'required',

        ]);
        $image_path = '';
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
            }
        }
        else {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini.');
        }
    }
}