<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Str;
use Auth;

class StudentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    // Test That Student Account can be created
    public function testCreateAccountPass()
    {
        $faker =  Faker::create();
        $password = Str::random(5);
        
        $payload = [
            'name' => $faker->name,
            'email' => $faker->unique()->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->json('post', '/api/student/createAccount', $payload)
            ->assertStatus(200)
            ->assertJson(['success' => True]);

    }
    
    // Check That Create Account Failed with Bad Request
    public function testCreateAccountFail()
    {
        $faker =  Faker::create();
        $password = Str::random(5);
        
        $payload = [
            'name' => $faker->name,
            'email' => '',
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->json('post', '/api/student/createAccount', $payload)
            ->assertStatus(400);
            

    }
    
    // Check That Login pass
    public function testLoginPass()
    {
        $faker =  Faker::create();
        $password = Str::random(5);
        $email = $faker->unique()->email;
        
        $payload = [
            'name' => $faker->name,
            'email' => $email ,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->json('post', '/api/student/createAccount', $payload);
        
        $payload = [
            
            'email' => $email,
            'password' => $password,
            
        ];
        
        $this->json('post', '/api/student/login', $payload)
            ->assertStatus(200);
                  

    }
    
    // Check that Login Failed with bad request
    public function testLoginFail()
    {
      
        $password = Str::random(5);
        $email = '';
        
       
        
        $payload = [
            
            'email' => $email,
            'password' => $password,
            
        ];
        
        $this->json('post', '/api/student/login', $payload)
            ->assertStatus(400);
                  

    }
    
    // check that course registration with user authentication passed 
    public function testCourseRegistrationPassWithAuth()
    {
        
        $this->createStudentAccount();
        try{
            $student_id = Student::orderBy('id','desc')
                             ->first()->id;
        
            $course_id = Course::orderBy('id','desc')
                             ->first()->id;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
        
        
        $payload = [
            
            'student_id' => $student_id,
            'course_id' => $course_id,
            
        ];
        
        $student_login = Auth::loginusingid($student_id);
        $this->actingAs($student_login, 'api')->json('POST', '/api/course/register',$payload)
             ->assertStatus(200);
        
       
                  
    }
    
    // Check That Course Registration Failed without authentication
    public function testCourseRegistrationFailWithoutAuth()
    {
        
        
        $student_id = '';
        
        try{
            $course_id = Course::orderBy('id','desc')
                             ->first()->id;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
        
        $payload = [
            
            'student_id' => $student_id,
            'course_id' => $course_id,
            
        ];
        
        $this->json('post', '/api/course/register', $payload)
            ->assertStatus(401);
                  
    }
    
    // Check That Course registration failed due to bad request with authentication
    public function testCourseRegistrationFailWithAuth()
    {
        
        
        $this->createStudentAccount();
        
        try{
        
            $student_id = Student::orderBy('id','desc')
                             ->first()->id;
        
            $course_id = Course::orderBy('id','desc')
                             ->first()->id;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
        
        $payload = [
            
            'student_id' => '',
            'course_id' => $course_id,
            
        ];
        
        $student_login = Auth::loginusingid($student_id);
        $this->actingAs($student_login, 'api')->json('POST', '/api/course/register',$payload)
             ->assertStatus(400);
        
                  
    }
    
    // Check Get Course List with Authentication passed
    public function testGetCourseListWithAuth()
    {
        
        
        $this->createStudentAccount();
        
        try{
        
            $student_id = Student::orderBy('id','desc')
                             ->first()->id;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
        
        $student_login = Auth::loginusingid($student_id);
        $this->actingAs($student_login, 'api')->json('GET', 'api/course/list')
             ->assertStatus(200);
        
                  
    }
    
    // Check Get Course List without Authentication failed
    public function testGetCourseListWithoutAuth()
    {
        
        $this->json('GET', '/api/course/list')
             ->assertStatus(401);
                  
    }
    
    // Creates a user account to facilitate course registration request and get course list testing.
    function createStudentAccount()
    {
        $faker =  Faker::create();
        $password = Str::random(5);
        $email = $faker->unique()->email;
        
        $payload = [
            'name' => $faker->name,
            'email' => $email ,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->json('post', '/api/student/createAccount', $payload);
    }
    
    
}
