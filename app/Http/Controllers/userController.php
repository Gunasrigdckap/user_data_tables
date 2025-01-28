<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{

//fetch data using join query
 public function usersdata(){
    $users = User::
    leftJoin('students_subjects','users.id','=','students_subjects.user_id')
    ->select('users.id','users.name','users.age','users.dept','users.email','students_subjects.subjects')
    ->get();
    return response()->json(['data'=>$users]);
    // dd($role);
    // if($role == 'admin'){
    //     return view('index');
    // }
    // elseif($role == 'user'){
    //     return view('welcome');
    // }
 }
     public function insertdata(Request $request){
        $user = User::create([
            'name' => $request->name,
            'age' => $request->age,
            'dept' => $request->dept,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $userId = $user->id;

        // $subjects = explode(',',$request->subject);

           subject::insert([
            'user_id' => $userId,
            'subjects' => str_replace(' ',',',$request->subjects)
           ]);



            // dd($user);
            // $user = new User;
            // $user->name = $request->name;
            // $user->id  = $request ->id;
            // $user->age = $request->age;
           // $user->dept = $request->dept;
           // $user->email = $request->email;
           // $user->password = bcrypt($request->password);
           // $user->save();

        return response()->json($user);
     }



     public function fileupload(Request $request){
            return view('fileupload');

     }

     public function import(Request $request)
     {

    $request->validate([
        'file' => 'required|mimes:csv',
    ]);
         $file = $request->file('file');
         $fileData = file($file->getPathname());

         foreach ($fileData as $importdata) {
             $data = str_getcsv($importdata);

             $user = User::create([
                 'name' => $data[0],
                 'age' => $data[1],
                 'dept' => $data[2],
                 'email' => $data[3],
                 'password' => bcrypt($data[4]),
             ]);
             $userId = $user->id;

             // $subjects = explode(',',$request->subject);

                subject::insert([
                 'user_id' => $userId,
                 'subjects' => $data[5]
                ]);


         }


         return view('index');
     }

}
