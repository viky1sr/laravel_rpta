<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListBookingController extends Controller
{
    public function pending() {
        return view('pages.list-booking.pending');
    }

    public function onProgress() {
        return view('pages.list-booking.on-progress');
    }

    public function success() {
        return view('pages.list-booking.success');
    }

    public function reject() {
        return view('pages.list-booking.reject');
    }
}
