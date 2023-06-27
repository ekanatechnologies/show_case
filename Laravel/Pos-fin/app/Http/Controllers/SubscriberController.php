<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Utility;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;


class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscribtion.subscribeRegister');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(env('RECAPTCHA_MODULE') == 'yes')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation=[];
        }
        $this->validate($request, $validation);

        $default_language = env('DEFAULT_LANG');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $r = Role::findByName('Owner');
        $owner = User::create(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
                'parent_id' =>1,
                'plan_id' => 1,
                'lang' => $default_language,
            ]
        )->assignRole($r);

        // $r = Role::findByName('Owner');

        // $owner->assignRole($r);

        event(new Registered($owner));

        Auth::login($owner);

        
        return redirect()->route('stripe',\Illuminate\Support\Facades\Crypt::encrypt($request['plan_id']))->with("message",'sideBarNone');
        // return redirect(RouteServiceProvider::HOME);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function show(Subscribe $subscribe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscribe $subscribe)
    {
        //
    }

    public function dash($id)
    {
        return view('layouts.landing-new')->with('id',$id);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscribe $subscribe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscribe $subscribe)
    {
        //
    }

    public function PayPal($code)
    {
        $plan_id               = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan                  = Plan::find($plan_id);
        $admin_payment_setting = Utility::getAdminPaymentSetting();

        if($plan)
        {
            return view('subscribtion.paypalBtn',compact('plan', 'admin_payment_setting'));
            
        }
        else
        {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
       
    }
}
