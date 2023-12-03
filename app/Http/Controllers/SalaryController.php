<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $salariesByMonth = Salary::selectRaw('year,month')
            ->groupByRaw('year, month')
            ->orderByDesc('year')
            ->get();

        foreach ($salariesByMonth as $month) {
            $month->salaries = Salary::where('month', $month->month)
                ->where('year', $month->year)
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
        // dd($request);
        $request->validate([
            'userName' => 'required|string|max:255',
            'basicSalary' => 'required',
            'attendancePercentage' => 'required',
            'salary' => 'required',
            'year' => 'required',
            'month' => 'required',
        ]);

        $existingSalary = DB::table('salaries')
            ->where('name', $request->userName)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->first();

        if ($existingSalary) {
            return redirect()->back()->with('error', 'Sudah membayar gaji untuk karyawan tersebut pada bulan ini.');
        }
        else {
            $attendancePercentage = $request->attendancePercentage;
            $month = ucwords($request->month);
            $year = $request->year;
            if(!$request->additional_salary){
                $additionalSalary = 0;    
            }
            else {
                $additionalSalary = $request->additionalSalary;
            }
            $additionalSalaryName = ucwords($request->additionalSalaryName);
            $salary = Salary::create([  
                'name' => $request->userName,
                'basic_salary' => $request->basicSalary,
                'attendance_precentage' => $attendancePercentage,
                'salary' => $request->salary,
                'additional_salary' => $additionalSalary,
                'additional_salary_name' => $additionalSalaryName,
                'month' => $month,
                'year' => $year,
            ]);
            if (!$salary) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mencatat pembayaran gaji.');
            }
            else{
                return redirect()->route('salary.index')->with('success', 'Sukses pencatat pembayaran gaji');
            }
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
        $salary->delete();
        return redirect()->back()->with('success', 'Sukses hapus pembayaran gaji.');
    }
}