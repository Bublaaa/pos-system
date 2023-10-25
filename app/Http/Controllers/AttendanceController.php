<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

        $allAttendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $allUserAttendance = $allAttendanceData->groupBy('name');

        $attendances = DB::table('attendances')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                'name',
                DB::raw('COUNT(*) as total_attendances')
            )
            ->where('status',1)
            ->groupBy(DB::raw('MONTH(created_at)'), 'name')
            ->get();

        // Organize data into a nested array
        $groupedData = [];
        foreach ($attendances as $data) {
            $month = date("F", mktime(0, 0, 0, $data->month, 1));
            $employeeName = $data->name;
            $totalAttendances = $data->total_attendances;

            // Group by month
            $groupedData[$month][$employeeName] = $totalAttendances;
        }
        
        return view('../layouts/contents/attendanceReport', [
            'totalDaysInMonth' => $totalDaysInMonth,
            'allUserAttendance' => $allUserAttendance,
            'groupedData' => $groupedData,
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