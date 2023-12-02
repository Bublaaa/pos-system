<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $employees = User::where('position','!=', 'owner')->get();
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $shifts = Shift::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->get();
        $now = Carbon::now();
        $totalDaysInMonth = $now->daysInMonth;
        $firstDayOfMonth = Carbon::createFromDate($now->year, $now->month, 1);
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();

        $datesArray = [];
        $currentDate = $firstDayOfMonth->copy();

        while ($currentDate->lte($lastDayOfMonth)) {
            switch ($currentDate->format('l')) {
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
            $datesArray[] = $day_name;
            $currentDate->addDay();
        }
        $employeeNameInShift = Shift::select('employee_name', DB::raw('COUNT(*) as shift_count'))
            ->groupBy('employee_name')
            ->get();
        $daysInWeek=['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $month_name='';
        switch ($now->format('F')) {
            case 'January':
                $month_name = 'Januari';
                break;
            case 'February':
                $month_name = 'Februari';
                break;
            case 'March':
                $month_name = 'Maret';
                break;
            case 'May':
                $month_name = 'Mei';
                break;
            case 'June':
                $month_name = 'Juni';
                break;
            case 'July':
                $month_name = 'Juli';
                break;
            case 'August':
                $month_name = 'Agustus';
                break;
            case 'October':
                $month_name = 'Oktober';
                break;
            case 'December':
                $month_name = 'Desember';
                break;
            default:
                $month_name = $now->format('F');
                break;
        };
        return view('../layouts/contents/shiftIndex')->with([
            'daysInWeek' => $daysInWeek,
            'employees' => $employees,
            'shifts' => $shifts,
            'employeeNameInShift' => $employeeNameInShift,
            'totalDaysInMonth' => $totalDaysInMonth,
            'month_name' => $month_name,
            'datesArray' => $datesArray,
            'now' => $now,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $request->validate([
            'userName' => 'string|max:255',
            'shift' => 'required',
        ]);
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $daysInMonth = Carbon::now()->daysInMonth;
        $shiftData = Shift::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->where('employee_name', $request->userName)->get();
        if($shiftData->count()==0){
            for($day = 0 ; $day<$daysInMonth; $day++){
                $date = $firstDayOfMonth;
                switch ($date->format('l')) {
                    case 'Monday':
                        $currentDayName = 'Senin';
                        break;
                    case 'Tuesday':
                        $currentDayName = 'Selasa';
                        break;
                    case 'Wednesday':
                        $currentDayName = 'Rabu';
                        break;
                    case 'Thursday':
                        $currentDayName = 'Kamis';
                        break;
                    case 'Friday':
                        $currentDayName = 'Jumat';
                        break;
                    case 'Saturday':
                        $currentDayName = 'Sabtu';
                        break;
                    case 'Sunday':
                        $currentDayName = 'Minggu';
                        break;
                    default:
                        $currentDayName = 'Invalid day';
                        break;
                }
                for ($dayInWeek = 0; $dayInWeek < count($request->shift); $dayInWeek++) {
                    $shiftPerDay = $request->shift[$dayInWeek];
                    $start_time = $shiftPerDay == 'siang' ? '10:00:00' : '15:00:00';
                    switch ($dayInWeek) {
                        case 0:
                            $day_name = 'Senin';
                            break;
                        case 1:
                            $day_name = 'Selasa';
                            break;
                        case 2:
                            $day_name = 'Rabu';
                            break;
                        case 3:
                            $day_name = 'Kamis';
                            break;
                        case 4:
                            $day_name = 'Jumat';
                            break;
                        case 5:
                            $day_name = 'Sabtu';
                            break;
                        case 6:
                            $day_name = 'Minggu';
                            break;
                        default:
                            $day_name = 'Invalid day';
                            break;
                    }
                    if($currentDayName == $day_name){
                        $shift = Shift::create([  
                            'name' => $shiftPerDay,
                            'start_time' => $start_time,
                            'day_name' => $day_name,
                            'employee_name' => $request->userName,
                            'created_at' => $date,
                        ]);
                        $date->addDay(1);
                    }
                }
            }   
            return redirect()->back()->with('success', 'Sukses memasukkan shift baru');
        }
        else{
            return redirect()->back()->with('error', 'Shift sudah terdaftar, Pilih update untuk mengganti shift');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('../layouts/contents/editShift');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$shift)
    {   
        $start_time='';
        $shiftData = Shift::find($shift);
        if ($shiftData) {
            if($request->shiftName == 'sore'){
                $start_time = '15:00:00';
            }
            else {
                $start_time = '10:00:00';
            }
            $shiftData->start_time = $start_time;
            $shiftData->name = $request->shiftName;
            $shiftData->save();
            return redirect()->back()->with('success', 'Sukses update shift');
        } else {
            return redirect()->back()->with('error', 'Gagal update shift');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }
}