<?php

namespace App\Http\Controllers\indent;

use App\Http\Controllers\Controller;
use App\Models\indent\indent_home;
use Illuminate\Http\Request;

class IndentHome extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      return view('content.digitize.indent.indent-home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(indent_home $indent_home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(indent_home $indent_home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, indent_home $indent_home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(indent_home $indent_home)
    {
        //
    }
}
