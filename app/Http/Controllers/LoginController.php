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

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // Logs a Student In
    public function loginStudent()
    {
            
        $value = Request::all();
        
        $rules = [
            
            'email' => 'required|max:100|email',
            'password' => 'required',
     
        ];
        
        $validator = Validator::make($value,$rules);
        
        if($validator->fails()){
            
            return response()->json(['error'=>$validator->errors()],400);             
            
        }
        else{
            
            try{// incase db is not connected or table does not exist
                
                if(Auth::attempt(['email' => Request::get('email'), 'password' => Request::get('password'), 'active'=>1])){
                    
                    $user = Auth::user();
                    $success['token'] =  $user->createToken('Laravel')->accessToken; 
                    $success['success'] = True;
                    return response()->json(['success' => $success],200);
                    
                } 
                else{
                    return response()->json(['error'=>'Invalid Login Credentials','failure' => True],400);
                }
            }
            catch(\Exception $e)
            {
                return response()->json(['error'=>$e->getMessage(),'failure'=>True],502);
            }
           
        }
    }

    // unauthenticated return function for protected routes
    public function index()
    {
        return response()->json(['error'=>' Sorry You are not Logged In','failure' => True],401);
    }
    
    
    

    
}
