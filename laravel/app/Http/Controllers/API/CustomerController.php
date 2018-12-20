<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    function getCustomer(Request $request){
        print_r($request->getContent());
    }
}
