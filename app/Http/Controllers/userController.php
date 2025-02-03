<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\subject;
use App\Models\studentMarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{

//fetch data using join query
//  public function usersdata(){
//     $users = User::
//     leftJoin('students_subjects','users.id','=','students_subjects.user_id')
//     ->select('users.id','users.name','users.age','users.dept','users.email','students_subjects.subjects')
//     ->get();
//     return response()->json(['data'=>$users]);
//     // dd($role);
//     // if($role == 'admin'){
//     //     return view('index');
//     // }
//     // elseif($role == 'user'){
//     //     return view('welcome');
//     // }
//  }




public function usersData(Request $request)
{
    $search = $request->get('search', '');
    $orderColumn = $request->get('orderColumn', 'id');
    $orderDirection = $request->get('orderDirection', 'asc');

    $users = User::
    leftJoin('students_subjects', 'users.id', '=', 'students_subjects.user_id')
        ->select('users.id', 'users.name', 'users.age', 'users.dept', 'users.email', 'students_subjects.subjects')
        ->when($search, function ($query ,$search) {
            $query->where('users.name','like',"%$search%")
                ->orWhere('users.email','like',"%$search%")
                ->orWhere('users.age','like',"%$search%")
                ->orWhere('users.dept','like',"%$search%")
                ->orWhere('students_subjects.subjects','like',"%$search%");
        })
        ->orderBy($orderColumn, $orderDirection)
        ->get();

    return response()->json(['data' => $users]);
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
     public function viewChart(Request $request){
        return view('chart');

     }

     public function studentmark(Request $request){
        $students = User::all();
        // dd($students->pluck('name'));
        return view('students_marks',compact('students'));

 }

 public function insertmark(Request $request){
    $student = User::find($request->student_id);
    $mark=$request->mark;
    if($mark <=100){
        $studentMark = studentMarks::create([
            'student_id' => $request->student_id,
            'name' => $student->name,
            'subject' => $request->subject,
            'mark'=>$mark
        ]);
    }
    else{
        return response()->json(['message' => 'Mark is not valid'], 400);
        }

    return response()->json($studentMark);
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
     public function getUserSubjectsAndMarks($userId)
     {
         // Fetch user data and their subjects and marks from the studentMarks table
         $user = User::find($userId);

         if (!$user) {
             return response()->json(['message' => 'User not found'], 404);
         }

         // Get subjects and marks for the user from the studentMarks table
         $marksData = studentMarks::where('student_id', $userId)->get();

         // If no marks data is found
         if ($marksData->isEmpty()) {
             return response()->json(['message' => 'No marks data found for this user'], 404);
         }

         // Return the subjects and marks as a response
         $data = $marksData->map(function($markEntry) {
             return [
                 'subject' => $markEntry->subject,
                 'mark' => $markEntry->mark,
             ];
         });

         return response()->json(['data' => $data]);
     }

 }



