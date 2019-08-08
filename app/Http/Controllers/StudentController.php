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
use App\Models\Student;
use Auth;

class StudentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // Create Student Account
    public function createAccount()
    {
        
        $value = Request::all();
        
        $rules = [
            
            'name' => 'required|max:100',
            'email' => 'required|max:100|unique:student,email|email',
            'password' => 'required|max:100|same:password_confirmation|min:5',
     
         ];
        
         try{// incase db is not connected or table does not exist
        
            $validator = Validator::make($value,$rules);
        
            if($validator->fails()){
            
                return response()->json(['error'=>$validator->errors()],400);
             
            }
            else{
                    
                $student = new Student();
                $student->name = Request::get('name');
                $student->email = Request::get('email');
                $student->password = Hash::make(Request::get('password'));
                $student->save();
             
             }
         }
         catch(\Exception $e){
               return response()->json(['error'=>$e->getMessage(),'failure'=>True],502);
         }
            
         $success['success'] = True;
           
         return response()->json(['success'=>$success],200); 
       
    }
    
}
