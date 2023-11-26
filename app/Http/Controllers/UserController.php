<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use App\Models\Attendance;
use App\Models\Transaction;
use App\Models\Salary;
use App\Models\Shift;

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
        $userData = User::where('id',$user->id)->first();
        $positionData = Position::where('name', '<>', 'owner')->get();
        return view('../layouts/contents/editUser') -> with(['user' => $userData,'positionData' => $positionData]);
    }
    public function update(Request $request, User $user){
        $request->validate([
            'userName' => 'required|string',
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'bank_name' => 'required|string',
            'address' => 'required|string',
            'account_number' => 'required|string',
        ]);
        $user->username = $request->userName;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->bank_name = strtoupper($request->bank_name);
        $user->account_number = $request->account_number;
        $user->address = $request->address;
        $image_path = '';
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::delete($user->profile_image);
            }
            $image_path = $request->file('profile_image')->store('images', 'public');
            $user->profile_image = $image_path;
        }

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
        
        $loggedInUser = Auth::user();
        if($loggedInUser->position == 'owner'){
            $user->position = $request->position;
            $user->basic_salary = $request->basic_salary;
        }
        else {
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
        }
        $user->save();
        if (!$user->save()) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat update user');
        }
        return redirect()->back()->with('success', 'Sukses update user.');
    }

    public function destroy(User $user){
        if ($user->profile_image) {
            Storage::delete($user->profile_image);
        }
        if($user->delete()){
            return redirect()->back()->with('success', 'Sukses delete akun.');
        }
    }
    public function show(){
        $user = auth()::get();
        
    }
}