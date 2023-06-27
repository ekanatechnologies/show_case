<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\UserCreate;
use App\Models\Branch;
use App\Models\CashRegister;
use App\Models\User;




class settingController extends Controller
{
    public function general(){
        return view('setting.general'); 
    }
    public function receipts(){
        return view('setting.receipts'); 
    }
   public function giftcards(){
        return view('setting.giftcards'); 
    }
    public function inventory(){
        return view('setting.inventory'); 
    }
      public function pos(){
          
          if (Auth::user()->can('Manage User')) {
              $user_id = Auth::user()->id;
               $branch= Branch::where('created_by', $user_id)->get();
             
            $users = User::select('users.*', DB::raw("COUNT(cu.parent_id) users"))->leftjoin('users as cu', 'cu.parent_id', '=', 'users.id')->where('users.parent_id', '=', Auth::user()->getCreatedBy())->groupBy('users.id')->orderBy('users.id', 'DESC')->get();
            return view('setting.pos', compact('users', 'branch'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
    }
    
    
}
