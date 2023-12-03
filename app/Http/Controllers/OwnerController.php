<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Menu;
use App\Models\Ingredient;
use App\Models\Transaction;
use App\Models\Stock;
use App\Models\User;
use App\Models\Salary;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class OwnerController extends Controller
{
    public function register() {
        $positionData = Position::get();
        return view('auth.register')->with(['positionData' => $positionData]);
    }
    

    public function printReceipt($id)
    {
        try {
            $salary = Salary::find($id);
            $user = User::where('position', 'owner')->first();
            $filename = $salary->name . '_' . date('F_Y', strtotime($salary->created_at)) . '_kwitansi.pdf';

            // Load the Blade view with the salary, user, and the calculated amount in words
            $amountInWords = $this->getAmountInWords($salary->salary);

            // Pass the amountInWords to the view
            $pdf = PDF::loadView('pdf.receipt', compact('salary', 'user', 'amountInWords'));
            $pdf->setPaper('A6', 'landscape');

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Function to convert amount to words
    private function getAmountInWords($amount)
    {
        function capitalizeWords($str) {
            return ucwords($str);
        }

        function convert($number) {
            $number = str_replace('.', '', $number);

            if (!ctype_digit($number)) {
                throw new \Exception('Not a valid number');
            }

            $base = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
            $numeric = [1000000000000000, 1000000000000, 1000000000000, 1000000000, 1000000, 1000, 100, 10, 1];
            $unit = ['kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', ''];
            $result = '';

            if ($number == 0) {
                $result = 'nol';
            } else {
                for ($i = 0; $i < count($numeric); $i++) {
                    $count = floor($number / $numeric[$i]);

                    if ($count >= 10) {
                        $result .= convert($count) . ' ' . $unit[$i] . ' ';
                    } elseif ($count > 0 && $count < 10) {
                        $result .= $base[$count] . ' ' . $unit[$i] . ' ';
                    }

                    $number -= $numeric[$i] * $count;
                }

                $result = preg_replace('/satu puluh (\w+)/i', '$1 belas', $result);
                $result = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se$1', $result);
                $result = preg_replace('/\s{2,}/', ' ', trim($result));
            }

            return $result;
        }

        $convertedAmount = convert($amount);
        return capitalizeWords($convertedAmount . " Rupiah");
    }

    public function salaryPayment($userName, $attendancePercentage, $month, $year){
        function getDaysInMonthByName($year, $monthName)
        {
            // Convert month name to numeric representation
            $month = Carbon::parse("1 $monthName")->month;

            // Calculate the number of days in the month
            $firstDayOfMonth = Carbon::createFromDate($year, $month, 1);
            $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();

            return $firstDayOfMonth->diffInDays($lastDayOfMonth) + 1;
        }
        $daysInMonth = getDaysInMonthByName($year, $month);
        $currentMonth = Carbon::now();
        $ownerData = auth()->user();
        $userData = User::where('name', $userName)->first();
        
        return view('../layouts/contents/salaryPayment')->with([
            'month' => $month,
            'year' => $year, // Include the year in the data
            'userData' => $userData,
            'ownerData' => $ownerData,
            'daysInMonth' => $daysInMonth,
            'attendancePercentage' => $attendancePercentage,
        ]);
    }

}