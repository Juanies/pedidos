<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()   {
        $orders = Order::where("estado",  "Pendiente")->paginate(5);
        return view('welcome', compact('orders'));
    }
}
