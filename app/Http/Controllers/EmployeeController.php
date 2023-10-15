<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    public function index()
    {
        return view('../layouts/contents/dashboard');
    }
    public function report()
    {   
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now();
        $totalDaysInMonth = $currentMonth->daysInMonth;

        $employee = User::where('position', '!=', 'owner')->get();
        $attendanceData = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
        ->where('status', 1)
        ->get();
        $userAttendance = $attendanceData->groupBy('name');
        
        return view('../layouts/contents/attendanceReport', [
            'employees' => $employee,
            'attendanceData' => $attendanceData,
            'userAttendance' => $userAttendance,
            'totalDaysInMonth' => $totalDaysInMonth,
        ]);
    }
    public function salary()
    {
        return view('../layouts/contents/salary');
    }
}