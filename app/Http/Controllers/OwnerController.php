<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function register(){
        return view('../auth.register'); 
    }
    public function attendanceReport(){
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
    public function salaryReport(){
        return view('../layouts/contents/salaryReport');
    }
    public function stockReport(){
        return view('../layouts/contents/stockReport');
    }
    public function addStock(){
        return view('../layouts/contents/addStock');
    }
    public function addMenu(){
        return view('../layouts/contents/addmenu');
    }
    public function editMenu(){
        return view('../layouts/contents/editMenu');
    }
}