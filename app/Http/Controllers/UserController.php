<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Transaction;

class UserController extends Controller
{
    public function index(){
        $users = User::where('position', '!=', 'owner')->get();
        return view('../layouts/contents/userIndex') -> with(['users' => $users]);
    }
    public function edit(User $user){
        $userData = User::where('id',$user->id)->get();
        return view('../layouts/contents/editUser') -> with(['user' => $userData]);
    }
    public function update(Request $request, User $user){
        $transactionData = Transaction::where('user_name', $user->name)->get();
        foreach($transactionData as $data){
            $data->user_name = $request->name;
            $data->save();
        }

        $attendanceData = Attendance::where('name', $user->name)->get();
        foreach($attendanceData as $data){
            $data->name = $request->name;
            $data->save();
        }
        // Validate request
        $request->validate([
            'userName' => 'required|string',
            'name' => 'required|string',
            'position' => 'required',
        ]);
        
        
        // Update table with value of request
        $user->email = $request->userName;
        $user->name = $request->name;
        $user->position = $request->position;
        
        
        // Check updated menu
        if (!$user->save()) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat update user');
        }
        return redirect()->route('user.index')->with('success', 'Sukses update user.');
    }

    public function destroy(User $user){
        if($user->delete()){
            return redirect()->back()->with('success', 'Sukses delete akun.');
        }
    }
}