<?php

namespace App\Http\Controllers;

use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\DateTime;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(){
        $user = Auth::user();
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $currentMonth = Carbon::now();
        $totalDaysInMonth = $currentMonth->daysInMonth;
        
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

        $todayAttendanceData = Attendance::whereDate('created_at', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();
        $todayShiftData = Shift::where('day_name',$day_name)
            ->get();

        $allUserAttendanceThisMonth = Attendance::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $allAttendance = Attendance::orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('m'); // grouping by month and day
            });
            
        $attendances = DB::table('attendances')
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) as month'), 'name', DB::raw('COUNT(*) as total_attendances'))
            ->where(function ($query) {
                $query->where('status', 'hadir')
                        ->orWhere('status', 'terlambat');
            })
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'), 'name')
            ->get();
        $attendancesByMonth = DB::table('attendances')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%M") as month'), // Format the month name
                'name',
                'status',
                'image', 
                'description', 
                'latitude',
                'longitude', 
                'created_at'  
            )
            ->groupBy(
                DB::raw('DATE_FORMAT(created_at, "%M")'), // Group by the formatted month name
                'name',
                'status',
                'image', 
                'description', 
                'latitude',
                'longitude', 
                'created_at'
            )
            ->orderBy('created_at', 'desc')
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
        // dd($attendancesByMonth);
        return view('../layouts/contents/attendanceReport', [
            'totalDaysInMonth' => $totalDaysInMonth,
            'attendancesByMonth' => $attendancesByMonth,
            'groupedData' => $groupedData,
            'todayAttendanceData' => $todayAttendanceData,
            'todayShiftData' => $todayShiftData,
            'user' => $user,
            'allAttendance' =>$allAttendance,
        ]);
    }
    public function create(Request $request){
        // $userIP = '10.1.63.70';
        // $userIP = $request->ip();

        // $location = Location::get($userIP);
        // dd($location);

        return view('../layouts/contents/employeeAttendance');
    }
    
    public function store(Request $request){
        // Get the logged in user
        $user = Auth::user();
        // Get today date
        $today = now();
        $todayDayName = $today->format('l');
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
        // get the user attendance data today
        $entriesToday = Attendance::where('name', $user->name)
            ->whereDate('created_at', $today->format('Y-m-d'))
            ->count();
        // Shift empty condition
        if($userShift->count() == 0) {
            return redirect()->back()->with('error','Shift belum terdaftar, hubungi Head Bar untuk mendaftarkan shift');
        }
        else {
            $status='';
            $description = '';
            $image_path = '';
            if($request->attendanceStatus){
                if ($request->hasFile('attendanceImage')) {
                    $image = $request->file('attendanceImage');
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $maxSize = 1.5 * 1024 * 1024;
                    do {
                        $compressedImage = Image::make($image)
                            ->resize(800, null, function ($constraint) {$constraint->aspectRatio();})
                            ->encode('webp', 40);
                        $size = strlen($compressedImage->__toString());
                    } while ($size > $maxSize);
                    Storage::disk('public')->put('attendance/' . $filename, $compressedImage->__toString());
                    $image_path = 'attendance/' . $filename;
                }
                $startTimeCarbon = Carbon::createFromFormat('H:i:s', $userShift[0]->start_time);
                $timeDifference = $today->diffInMinutes($startTimeCarbon);
                $minutesDifference = $timeDifference % 60; 
                $hoursDifference = floor($timeDifference / 60);

                // Late and ealry condition
                if ($today->isBefore($startTimeCarbon)) {
                    $status = "hadir";
                    $description = 'Absen lebih awal ' . $hoursDifference . ' Jam ' . $minutesDifference . ' Menit';
                } 
                elseif ($today->isAfter($startTimeCarbon)) {
                    $status = "terlambat";
                    $description = 'Terlambat absen ' . $hoursDifference . ' Jam ' . $minutesDifference . ' Menit';

                } else {
                    $status = "hadir";
                    $description = 'Berhasil absen tepat waktu';
                }
                if ($entriesToday == 0) {
                    $attendance = Attendance::create([  
                        'name' => $user->name,
                        'description' => $description,
                        'image' => $image_path,
                        'status' => $status,
                        'latitude' =>$request->latitude,
                        'longitude' =>$request->longitude,
                    ]);
                    if (!$attendance) {
                        return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan presensi.');
                    }
                    else{
                        return redirect()->back()->with('success', 'Presensi Sukses');
                    }
                }
                else {
                    return redirect()->back()->with('error', 'Anda sudah presensi hari ini.');
                }
            }
            elseif($request->absentStatus){
                if ($request->hasFile('absentImage')) {
                    $image = $request->file('absentImage');
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $maxSize = 1.5 * 1024 * 1024;
                    do {
                        $compressedImage = Image::make($image)
                            ->resize(800, null, function ($constraint) {$constraint->aspectRatio();})
                            ->encode('webp', 40);
                        $size = strlen($compressedImage->__toString());
                    } while ($size > $maxSize);
                    Storage::disk('public')->put('attendance/' . $filename, $compressedImage->__toString());
                    $image_path = 'attendance/' . $filename;
                }
                $status='ijin';
                $description = $request->description;
                $startDateCarbon = Carbon::createFromFormat('Y-m-d', $request->startDate);
                $endDateCarbon = Carbon::createFromFormat('Y-m-d', $request->endDate);
                $timeDifference = $startDateCarbon->diff($endDateCarbon);
                $daysDifference = $timeDifference->days;
                for ($day = 0; $day <= $daysDifference; $day++) {
                    $attendance = Attendance::create([  
                        'name' => $user->name,
                        'description' => $description,
                        'image' => $image_path,
                        'status' => $status,
                        'latitude' =>$request->absentLatitude,
                        'longitude' =>$request->absentLongitude,
                        'created_at' => $startDateCarbon->addDay($day),
                    ]);
                }
                if (!$attendance) {
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan absensi.');
                }
                else{
                    return redirect()->back()->with('success', 'Absensi sukses');
                }
            }
        }
    }
    public function destroy(Attendance $attendance){
        if ($attendance->image) {
            Storage::delete($attendance->image);
        }
        $attendance->delete();
        return redirect()->back()->with('success', 'Sukses delete presensi.');
    }
}