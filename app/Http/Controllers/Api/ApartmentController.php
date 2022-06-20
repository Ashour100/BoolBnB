<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Apartment;

class ApartmentController extends Controller
{
    public function index(){
        $apartments = Apartment::with(['messages','user'])->paginate(12);

        return response()->json($apartments);
    }
}
