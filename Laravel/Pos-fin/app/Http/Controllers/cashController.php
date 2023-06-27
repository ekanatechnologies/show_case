<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cashController extends Controller
{
  public function cashshow(){
    return view('cash.cashshow');
  }
  public function cashmove(){
        return view('cash.cashmove');
  }
}
