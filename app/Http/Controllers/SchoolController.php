<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schoolRepository = new \App\Repositories\SchoolRepository;
    }

    public function index() {

        $schools = $this->schoolRepository->lists();

        return view('school')->with('schools', $schools);
    }
}
