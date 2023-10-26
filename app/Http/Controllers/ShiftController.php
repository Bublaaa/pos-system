<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $employees = User::where('position','!=', 'owner')->get();
        $shifts = Shift::get();
        $daysInWeek=['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        return view('../layouts/contents/shiftIndex')->with([
            'daysInWeek' => $daysInWeek,
            'employees' => $employees,
            'shifts' => $shifts,
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
    public function store(Request $request)
    {
        $request->validate([
            'userName' => 'string|max:255',
            'shift' => 'required',
        ]);
        $shiftData = Shift::where('employee_name', $request->userName)->get();
        if($shiftData->count()==0){
            foreach($request->shift as $day => $shiftPerDay){
                $start_time = $shiftPerDay == 'siang' ? '10:00:00' : '15:00:00';
                switch ($day) {
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
                $shift = Shift::create([  
                    'name' => $shiftPerDay,
                    'start_time' => $start_time,
                    'day_name' => $day_name,
                    'employee_name' => $request->userName,
                ]);
            }
            if(!$shift) {
                return redirect()->back()->with('error', 'Gagal memasukkan shift baru');
            }
            else {
                return redirect()->back()->with('success', 'Sukses memasukkan shift baru');
            }
        }
        else {
            foreach($request->shift as $day => $shiftPerDay)
            {
                $start_time = $shiftPerDay == 'siang' ? '10:00:00' : '15:00:00';
                $shiftData[$day]['name'] = $shiftPerDay;
                $shiftData[$day]['start_time'] = $start_time;
                $shiftData[$day]->save();
            }
            return redirect()->back()->with('success', 'Sukses update shift');
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
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
    }
}