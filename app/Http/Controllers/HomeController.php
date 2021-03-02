<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('auth')->except('store');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('home', ['reservations'=>$reservations]);
    }

    /**
     * Store a reservation data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        /* Validate data first.
           User is automatically taken back on errors
        */ 
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|max:255',
            'number_guests' => 'required|integer',
            'date' => 'required|max:255',
            'time' => 'required|max:255',
            'message' => 'max:255',
        ]);

        // Save in DB
        $reservation = Reservation::create($validatedData);
        // Let user know all went well
        return redirect('/#reservation')->with('status', 'Reservation was placed');
    }
}
