<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShiftSchedules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

class shifthourController extends Controller
{
    public function shifthour(){
        if (Auth::user()->can('Manage Shift')) {
            
        return view('shifthour.shifthours');
        }else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    } 
    public function shiftList(Request $request){
             $user_id = Auth::user()->getCreatedBy();
        $shiftData = ShiftSchedules::where('created_by', $user_id)->get();
        
        $branch= Branch::where('created_by', $user_id)->get();
        // $shiftData = ShiftSchedules::all();
        $users = User::where('parent_id', $user_id)->get();
    $data =compact('shiftData','users','user_id','branch');
    return view('shifthour.shifthours')->with($data);

    } 
    public function store(Request $request)
    {
        $user_id = Auth::user()->getCreatedBy();
        $Shift = new ShiftSchedules();
        $Shift->employeeName = $request['employeeName'];
        $Shift->shifts = $request['shifts'];
        $Shift->shiftsDate = $request['shiftsDate'];
        $Shift->startTime = $request['startTime'];
        $Shift->endTime = $request['endTime'];
        $Shift->breakTime = $request['breakTime'];
        $Shift->created_by = Auth::user()->getCreatedBy();
        $Shift->branch_id   = $request['branch_id'];
        $Shift->save();
        return redirect('shifthours');

    }
}