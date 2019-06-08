<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DOMDocument;
use DOMXPath;
use DB;

class DataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url = 'http://www.pshs.edu.ph/nce2018';
        
        $this->divisionRepository = new \App\Repositories\DivisionRepository;
        $this->schoolRepository = new \App\Repositories\SchoolRepository;
        $this->passerRepository = new \App\Repositories\PasserRepository;        
    }

    public function load()
    {
        try {

            $data = file_get_contents($this->url);

            libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->loadHTML($data);
            $xpathDoc = new DOMXpath($doc);

            // get names data that contains: "width: 270px; text-align: left; padding: 0px 17px"
            $names = $xpathDoc->query('//div[contains(@style,"width: 270px; text-align: left; padding: 0px 17px")]');
            
            // get schools data that contains: "width: 300px; padding: 0px 11px;"
            $schools = $xpathDoc->query('//div[contains(@style,"width: 300px; padding: 0px 11px")]');
            $arrSchools = [];

            // get divisions data that contains: "width: 300px; padding: 0px 11px;"
            $divisions = $xpathDoc->query('//div[contains(@style,"width: 179px; padding: 0px 17px 0px 16px;")]');
            $arrDivisions = [];

            //Divisions
            foreach ($divisions as $key => $val) {

                $division = $val->nodeValue;

                $arrDivisions[] = $division;

                //if division !exist then create new
                if (!$this->divisionRepository->exist($division)) {

                    $this->divisionRepository->store(['name' => $division]);

                }
            }


            
        
            //Schools
            foreach ($schools as $key => $val) {

                $school = $val->nodeValue;

                $arrSchools[] = $school;

               

                //if school !exist then create new
                if (!$this->schoolRepository->exist($school)) {

                    // get division
                    $division = $this->divisionRepository->getFirstByColumn(['name' => $arrDivisions[$key]]);

                    if ($division) {

                        $this->schoolRepository->store(['name' => $school, 'division_id' => $division->id]);

                    }
                }

            }

            //Names
            foreach ($names as $key => $val) {

                $name = explode(",", $val->nodeValue);
                $firstName = $name[1];
                $lastName = $name[0];
    
                $school = $arrSchools[$key];
    
                // get examinee  by firstname and lastname
                //get school by name 
                $passer = $this->passerRepository->getFirstByColumn(['firstname' => $firstName, 'lastname' => $lastName]);
                $school = $this->schoolRepository->getFirstByColumn(['name' => $school]);
                
                //if examinee is empty and school exists
                //then create new examinee
                if (!$passer && $school) {
    
                    $this->passerRepository->store([
                        'firstname' => $firstName,
                        'lastname'  => $lastName,
                        'school_id' => $school->id
                    ]);
                   
                }
    
    
            }   
            
            
            return response()->json([
                'result' => true,
                'message' => 'Successfully loading data from URL'
            ]);

            
        } catch(\Exception $e) {

            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
        
    }


    public function get()
    {
        try {

            $search = !empty(request()->search) ?    request()->search  :   '';

            $passers = $this->passerRepository->getPassers($search);
            
            return response()->json(['result' => true, 'passers' => $passers]);

        } catch (\Exception $e) {

            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
        
    }


    public function create()
    {
        \DB::beginTransaction();

        try {

            // get division name data if exist or else create
            $division = $this->divisionRepository->firstOrCreate(
                ['name' => request()->division],
                ['name' => request()->division]
            );

            // get school name data if exist or else create
            $school = $this->schoolRepository->firstOrCreate(
                ['name' => request()->school],
                [
                    'name' => request()->school,
                    'division_id' => $division->id
                ]
            );

            
            //create new examinee
            $create = $this->passerRepository->store([
                'firstname' => request()->firstname,
                'lastname' => request()->lastname,
                'school_id' => $school->id
            ]);

           
            if ($create) {
                \DB::commit();

                return response()->json(['result'=> true, 'message'=> 'Successfully creating new examinee']);

            } else {
                return response()->json(['result'=> false, 'message'=> 'Error on creating new examinee.']);
            }

        } catch(\Exception $e) {

            return response()->json(['result'=> false, 'message'=> $e->getMessage()]);
        }
    }

}
