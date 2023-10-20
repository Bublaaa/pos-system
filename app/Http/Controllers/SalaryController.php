<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salariesByMonth = Salary::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year')
        ->groupByRaw('YEAR(created_at), MONTH(created_at)')
        ->get();

        // Retrieve detailed salary data for each month
        foreach ($salariesByMonth as $month) {
        $month->salaries = Salary::whereMonth('created_at', $month->month)
            ->whereYear('created_at', $month->year)
            ->select('id', 'name', 'basic_salary', 'attendance_precentage', 'salary', 'created_at')
            ->get();
        }

        return view('../layouts/contents/salaryReport') -> with(['salariesByMonth' => $salariesByMonth]);
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
            'userName' => 'required|string|max:255',
            'basicSalary' => 'required',
            'attendanceCount' => 'required',
            'totalDaysInMonth' => 'required',
            'salary' => 'required',
        ]);
        $attendanceCount = (int) $request->attendanceCount;
        $totalDaysInMonth = (int) $request->totalDaysInMonth;
        $attendancePercentage = round(($request->attendanceCount / $request->totalDaysInMonth) * 100);
        $salary = Salary::create([  
            'name' => $request->userName,
            'basic_salary' => $request->basicSalary,
            'attendance_precentage' => $attendancePercentage,
            'salary' => $request->salary,
        ]);
        if (!$salary) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencatat pembayaran gaji.');
        }
        else{
            return redirect()->route('salary.index')->with('success', 'Sukses pencatat pembayaran gaji');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }
}