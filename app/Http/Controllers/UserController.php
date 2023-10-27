<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Transaction;
use App\Models\Salary;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $loggedInUser = Auth::user(); 
        if($loggedInUser->position == "owner"){
            $users = User::where('position', '!=', 'owner')->get();
            return view('../layouts/contents/userIndex') -> with(['users' => $users]);
        }
        else {
            $user = $loggedInUser; 
            return view('../layouts/contents/editAccount')->with(['user' => $user]);
        }
    }
    public function edit(User $user){
        $userData = User::where('id',$user->id)->get();
        return view('../layouts/contents/editUser') -> with(['user' => $userData]);
    }
    public function update(Request $request, User $user){
        $loggedInUser = Auth::user();
        if($loggedInUser->position == 'owner'){
            // Update transaction data
            $transactionData = Transaction::where('user_name', $user->name)->get();
            foreach($transactionData as $data){
                $data->user_name = $request->name;
                $data->save();
            }
            //Update salary data
            $salaryData = Salary::where('name', $user->name)->get();
            foreach($salaryData as $data){
                $data->name = $request->name;
                $data->save();
            }
            //Update attendance data
            $attendanceData = Attendance::where('name', $user->name)->get();
            foreach($attendanceData as $data){
                $data->name = $request->name;
                $data->save();
            }
            //Update shift data
            $attendanceData = Shift::where('employee_name', $user->name)->get();
            foreach($attendanceData as $data){
                $data->employee_name = $request->name;
                $data->save();
            }
            // Validate request
            $request->validate([
                'userName' => 'required|string',
                'name' => 'required|string',
                'position' => 'required',
            ]);
            
            // Update table with value of request
            $user->username = $request->userName;
            $user->name = $request->name;
            $user->position = $request->position;
            
            
            // Check updated user
            if (!$user->save()) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat update user');
            }
            return redirect()->route('user.index')->with('success', 'Sukses update user.');
        }
        if($request->oldPassword){
            $request->validate([
                'oldPassword' => 'required',
                'newPassword' => 'required',
            ]);
            if (Hash::check($request->oldPassword, $user->password)) {
                // Update the user's password
                $user->update(['password' => bcrypt($request->newPassword)]);

                return redirect()->back()->with('success', 'Berhasil ganti kata sandi.');
            } else {
                return redirect()->back()->with('error', 'Kata sandi lama tidak cocok.');
            }
        }
        $user->username = $request->userName;
        $user->save();
        return redirect()->back()->with('success', 'Berhasil ganti username.');        
    }

    public function destroy(User $user){
        if($user->delete()){
            return redirect()->back()->with('success', 'Sukses delete akun.');
        }
    }
    public function show(){
        $user = auth()::get();
        
    }
}