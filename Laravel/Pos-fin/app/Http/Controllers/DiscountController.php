<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(){
        return view('Discount.discounts');
    }
    
    public function create(){
        return view('Discount.create');
    }
    public function store(Request $request){
        return view('Discount.create');
    }
}