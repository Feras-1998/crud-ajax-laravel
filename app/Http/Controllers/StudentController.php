<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        return view('student.index');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'course'=>'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        } else {
            $student = new Student();
            $student->name=$request->input('name');
            $student->email=$request->input('email');
            $student->phone=$request->input('phone');
            $student->course=$request->input('course');
            $student->save();

            return response()->json([
                'status'=>200,
                'message'=>'student added successfully',
            ]);
        }
    }

    public function fetchStudent(){
        $students = Student::all();
        return response()->json([
            'students'=>$students
        ]);
    }

    public function edit($id){
        $student = Student::find($id);

        if ($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Student Not Found',
            ]);
        }
    }

    public function update(Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'course'=>'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        } else {
            $student = Student::find($id);

            if ($student){
                $student->name=$request->input('name');
                $student->email=$request->input('email');
                $student->phone=$request->input('phone');
                $student->course=$request->input('course');
                $student->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'student updated successfully',
                ]);
            } else {
                return response()->json([
                    'status'=>404,
                    'message'=>'Student Not Found',
                ]);
            }
        }
    }

    public function delete(int $id){
        $student = Student::find($id);

        if ($student){
            $student->delete();

            return response()->json([
                'status'=>200,
                'message'=>'student Deleted successfully',
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Student Not Found',
            ]);
        }
    }
}
