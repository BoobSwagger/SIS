<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // --- READ (Display List) ---
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    // --- CREATE (Show Form) ---
    public function create()
    {
        return view('students.create');
    }

    // --- CREATE (Save Data & Auto-Generate ID) ---
    public function store(Request $request)
    {
        // 1. Validates that the submitted data is correct
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'age'        => 'required|integer|min:1',
            'course'     => 'required|string|max:255',
            'gender'     => 'required|string',
        ]);

        // 2. Auto-Generate the Student ID starting from 20260001
        $lastStudent = Student::orderBy('student_id', 'desc')->first();
        
        if (!$lastStudent || $lastStudent->student_id < 20260001) {
            $newStudentId = '20260001';
        } else {
            $newStudentId = (string)($lastStudent->student_id + 1);
        }

        // 3. Add the generated ID to the validated data array
        $validatedData['student_id'] = $newStudentId;

        // 4. Saves the new student with the generated ID
        Student::create($validatedData);
        return redirect('/students');
    }

    // --- UPDATE (Show Edit Form) ---
    public function edit($id)
    {
        // Finds the specific student by their ID and loads the edit form
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    // --- UPDATE (Save Changes) ---
    public function update(Request $request, $id)
    {
        // 1. Validates that the submitted data is correct
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'age'        => 'required|integer|min:1',
            'course'     => 'required|string|max:255',
            'gender'     => 'required|string',
        ]);

        // 2. Finds the student and updates their record
        $student = Student::findOrFail($id);
        $student->update($validatedData);

        // 3. Sends you back to the list
        return redirect('/students');
    }

    // --- DELETE (Remove Record) ---
    public function destroy($id)
    {
        // Finds the student and deletes them from the database
        $student = Student::findOrFail($id);
        $student->delete();

        // Sends you back to the list
        return redirect('/students');
    }

    public function truncate()
    {
        // Deletes all records from the database
        Student::truncate();
        return redirect('/students');
    }
}