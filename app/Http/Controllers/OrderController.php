<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function store(Request $request) {
        return view('consumer.order');
    }
}
