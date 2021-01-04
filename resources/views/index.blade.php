@extends('layouts.app')

@section('content')
  <button v-on:click="showAddForm" class="btn btn-primary">Add Employee</button>
  <button v-on:click="showDelete" class="btn btn-danger">Delete</button>
  <br>
  <br>
  {{-- <employee-table :employees-data="{{ json_encode($employees) }}"></employee-table> --}}
  <employee-table ref="employeeTable"></employee-table>
  <div v-show="displayForm">
    <employee-form ref="employeeForm"></employee-form>
  </div>
  <br>
  <br>
@endsection