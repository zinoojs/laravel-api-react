<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{   
    private $status     =   200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        if(count($students) > 0) {
            return response()->json(["status" => $this->status, "success" => true, "count" => count($students), "data" => $students]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // private $status     =   200;
        // validate inputs
        $validator          =       Validator::make($request->all(),
            [
                "name"        =>      "required",
                "email"             =>      "required|email",
                "phone"             =>      "required|numeric",
                "gender"         =>      "required",
            ]
        );

        // if validation fails
        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }
         $studentArray           =       array(
            "name"            =>      $request->name,
            "email"           =>      $request->email,
            "phone"           =>      $request->phone,
            "gender"          =>      $request->gender,
        );
    
        $student        =       Student::create($studentArray);
        if(!is_null($student)) {            
            return response()->json(["status" => $this->status, "success" => true, "message" => "student record created successfully", "data" => $student]);
        }    
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
             
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $student =  Student::find($id);
        if(!is_null($student)) {
            return response()->json(["status" => $this->status, "success" => true, "data" => $student]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no student found"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   

        $validator          =       Validator::make($request->all(),
            [
                "name"        =>      "required",
                "email"             =>      "required|email",
                "phone"             =>      "required|numeric",
                "gender"         =>      "required",
            ]
        );

        // if validation fails
        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }
         $studentArray           =       array(
            "name"            =>      $request->name,
            "email"           =>      $request->email,
            "phone"           =>      $request->phone,
            "gender"          =>      $request->gender,
        );
        $updated_status     =       Student::where("id", $id)->update($studentArray);
        if($updated_status == 1) {
            return response()->json(["status" => $this->status, "success" => true, "message" => "student detail updated successfully"]);
        }
        else {
            return response()->json(["status" => "failed", "message" => "Whoops! failed to update, try again."]);
        }               
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destory($id)
    {
        $student =  Student::find($id);
        if(!is_null($student)) {
            $delete_status      =       Student::where("id", $id)->delete();
            if($delete_status == 1) {
                return response()->json(["status" => $this->status, "success" => true, "message" => "student record deleted successfully"]);
            }
            else{
                return response()->json(["status" => "failed", "message" => "failed to delete, please try again"]);
            }
        }
        else {
            return response()->json(["status" => "failed", "message" => "Whoops! no student found with this id"]);
        }
    }
}
