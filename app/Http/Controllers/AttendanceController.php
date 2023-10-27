<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Shift;

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
        // Validate form
        $request->validate([
            'status' => 'required|boolean',
            'latitude' => 'required',
            'longitude' => 'required',

        ]);
        $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('attendance', 'public');
        }
        // Get the logged in user
        $user = Auth::user();
        // Get today date
        $today = now();
        $todayDayName = $today->format('l');
        // Translate day from table into indonesian
        switch ($todayDayName) {
        case 'Monday':
            $day_name = 'Senin';
            break;
        case 'Tuesday':
            $day_name = 'Selasa';
            break;
        case 'Wednesday':
            $day_name = 'Rabu';
            break;
        case 'Thursday':
            $day_name = 'Kamis';
            break;
        case 'Friday':
            $day_name = 'Jumat';
            break;
        case 'Saturday':
            $day_name = 'Sabtu';
            break;
        case 'Sunday':
            $day_name = 'Minggu';
            break;
        default:
            $day_name = 'Invalid day';
            break;
        }
        //Get the user today shift data
        $userShift = Shift::where('employee_name', $user->name)->where('day_name',$day_name)->get();
        // Shift empty condition
        if($userShift->count() == 0) {
            return redirect()->back()->with('error','Shift belum terdaftar, hubungi Head Bar untuk mendaftarkan shift');
        }
        else {
            //Change start_time from shift data to Carbon type
            $startTimeCarbon = Carbon::createFromFormat('H:i:s', $userShift[0]->start_time);
            // Get time difference in hours and minutes
            $timeDifference = $today->diffInMinutes($startTimeCarbon);
            $minutesDifference = $timeDifference % 60; 
            $hoursDifference = floor($timeDifference / 60);
            
            // Late and ealry condition
            if ($today->isBefore($startTimeCarbon)) {
                $attendDescription = 'Absen lebih awal ' . $hoursDifference . ' Jam ' . $minutesDifference . ' Menit';
            } 
            elseif ($today->isAfter($startTimeCarbon)) {
                $attendDescription = 'Terlambat absen ' . $hoursDifference . ' Jam ' . $minutesDifference . ' Menit';

            } else {
                $attendDescription = 'Berhasil absen tepat waktu';
            }
            // get the user attendance data today
            $entriesToday = Attendance::where('name', $user->name)
                ->whereDate('created_at', $today->format('Y-m-d'))
                ->count();
            // Attendance once a day
            if ($entriesToday == 0) {
                $description = '';
                if($request->status == 1){
                    $description = $attendDescription;
                }
                else {
                    $description = $request->description;
                }
                $attendance = Attendance::create([  
                    'name' => $user->name,
                    'description' => $description,
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
}