<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeesController extends Controller
{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{

			$employees = Employee::orderby('lastname', 'asc')->paginate(10);
			return response()->json($employees);
			
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
				//
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'empno' => 'required',
				'firstname' => 'required|string',
				'lastname' => 'required|string',
				'middlename' => 'nullable',
				'email' => 'email|nullable',
				'phone' => 'string|nullable',
				'address' => 'nullable',
			]);


			//Create Employee
			$post = new Employee;
			$post->empno = strtoupper($request->input('empno'));
			$post->firstname = strtoupper($request->input('firstname'));
			$post->lastname = strtoupper($request->input('lastname'));
			$post->middlename = strtoupper($request->input('middlename'));
			$post->email = $request->input('email');
			$post->phone = $request->input('phone');
			$post->address = $request->input('address');
			$post->save();

      return response()->json(null, 200);
		}

		/**
		 * Display the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
				//
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
				//
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
			$this->validate($request, [
				'empno' => 'required',
				'firstname' => 'required|string',
				'lastname' => 'required|string',
				'middlename' => 'nullable',
				'email' => 'email|nullable',
				'phone' => 'string|nullable',
				'address' => 'nullable',
      ]);
      
			//Update Employee
			$post = Employee::find($id);
			$post->empno = strtoupper($request->input('empno'));
			$post->firstname = strtoupper($request->input('firstname'));
			$post->lastname = strtoupper($request->input('lastname'));
			$post->middlename = strtoupper($request->input('middlename'));
			$post->email = $request->input('email');
			$post->phone = $request->input('phone');
			$post->address = $request->input('address');
			$post->save();

      return response()->json(null, 200);        
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{

    }


    public function deleteMany(Request $request)
    {
      $id_array = is_array($request->id) ? $request->id : [$request->id];
      Employee::whereIn('id', $id_array)->delete(); // $request->id MUST be an array
      return response()->json(null, 200);
    }


}
