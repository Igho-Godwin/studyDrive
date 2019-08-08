<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use Request;
use Validator;
use Hash;
use DB;
use Session;
use App\Models\CourseRegistration;
use App\Models\Course;
use Auth;

class CourseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // Register For Course
    public function registerForCourse()
    {
       
        $value = Request::all();
        
        $rules = [    
                    'student_id' => 'required|numeric|exists:student,id',
                    'course_id' => 'required|numeric|exists:course,id',
                ];
        
        
        $validator = Validator::make($value,$rules);
        
        if($validator->fails()){
            
            return response()->json(['error'=>$validator->errors()],400);             
            
        }
        else{
                    
            $course_id = Request::get('course_id');
                    
            if($this->checkCourseLimit($course_id) == 1) // checks that course can be registered
            { 
                try{ // incase db is not connected or table does not exist
                    
                    $student = new CourseRegistration();
                    $student->student_id = Request::get('student_id');
                    $student->course_id = $course_id;
                    $student->registered_on = date('Y-m-d H:i:s');
                    $student->save();
                }
                catch(\Exception $e)
                {
                    return response()->json(['error'=>$e->getMessage(),'failure'=>True],502);
                }
            }
            else{
                 return response()->json(['error'=>'Course Limit Reached','failure'=>True],400);
            }
                    
            $user= Auth::user();
            $success['token'] =  $user->createToken('Laravel')->accessToken; 
            $success['success'] = True;
           
            return response()->json(['success'=>$success],200); 
            
        }
          
    }
    
    // Checks Course Limit returns 1 if course is still available for registration and 0 otherwise 
    public function checkCourseLimit($course_id)
    {
        
        try{ // incase db is not connected or table does not exist
            $capacity = Course::find($course_id)->capacity;
            
            $no_of_registered_courses = CourseRegistration::where('course_id',$course_id)
                              ->where('active',1)
                              ->count();
            
        }
        catch(\Exception $e)
        {
            return response()->json(['error'=>$e->getMessage(),'failure'=>True],502);
        }
        
        
        if($no_of_registered_courses < $capacity)
        {
            $no_of_registered_courses++;
            if($no_of_registered_courses >= $capacity) //Checks if just registered course makes course unavilable if so it updates it as such
            {
                $this->updateCourse($course_id);
            }
            return 1;
        }
        else{
             
            return 0;
                
        }
        
    }
    
    // Returns Course List showing available and unavailable course. Available having active as 1 and unavailable having active field as zero
    public function getCourseList()
    {
        try{// incase db is not connected or table does not exist
            $course_list = Course::all();
        }
        catch(\Exception $e)
        {
            return response()->json(['error'=>$e->getMessage(),'failure'=>True],502);
        }
        
        $user= Auth::user();
        $token = $user->createToken('Laravel')->accessToken;

        return response()->json(['course_list'=>$course_list,'token'=>$token],200);
    }
    
    //Sets Course to Unavilable
    public function updateCourse($course_id)
    {
        try{// incase db is not connected or table does not exist
            $obj = Course::find($course_id);
            $obj->active = 0;
            $obj->save();
        }
        catch(\Exception $e)
        {
            return response()->json(['error'=>$e->getMessage(),'failure'=>True],502);
        }
    }
    
    
    

    
}
