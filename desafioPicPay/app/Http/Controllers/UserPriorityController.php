<?php

namespace App\Http\Controllers;

use App\UserPriority;
use Illuminate\Http\Request;

class UserPriorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserPriority  $userPriority
     * @return \Illuminate\Http\Response
     */
    public function show(UserPriority $userPriority)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserPriority  $userPriority
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPriority $userPriority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPriority  $userPriority
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPriority $userPriority)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserPriority  $userPriority
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPriority $userPriority)
    {
        //
    }
}
