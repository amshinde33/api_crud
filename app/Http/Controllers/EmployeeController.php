<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required|numeric',
            'date_of_birth' => 'date|required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->age = $request->age;
        $employee->date_of_birth= $request->date_of_birth;
        $employee->save();

        return response()->json(["employee" => $employee, "message"=>"Employee has been created successfully"], 201);

    }


    public function update(Request $request, Employee $employee,$id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required|numeric',
            'date_of_birth' => 'date|required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $employee =Employee::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->age = $request->age;
        $employee->date_of_birth= $request->date_of_birth;
        $employee->save();

        return response()->json(["employee" => $employee, "message"=>"Employee has been updated successfully"], 200);

    }

    public function delete($id)
    {
        $employee =Employee::find($id);
        $employee->is_delete = 1;
        $employee->save();

        return response()->json(['Success', "message"=>"Employee has been deleted successfully"]);
    }
}
