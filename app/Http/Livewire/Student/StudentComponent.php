<?php

namespace App\Http\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentComponent extends Component
{

    use WithFileUploads;
    public $roll,$name,$image,$email,$phone,$student_edit_id,$student_delete_id;


    public function storeStudentData()
    {

          //on form submit validation
          
          $this->validate([
            'roll' => 'required|unique:students', //students = table name
            'name' => 'required',
            'image'=>'required|image',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        // Add Student Data
        $student = new Student();
        $student->roll = $this->roll;
        $student->name = $this->name;

       
       if($this->image != ''){
     $student->image = $this->image->store('student','public');
       }
        $student->email = $this->email;
        $student->phone = $this->phone;

        $student->save();

        session()->flash('message', 'New student has been added successfully');

        $this->roll = '';
        $this->name = '';
        $this->image = '';
        $this->email = '';
        $this->phone = '';
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->roll = '';
        $this->name = '';
        $this->image = '';
        $this->email = '';
        $this->phone = '';
    }

    

    public function close()
    {
        $this->resetInputs();
    }


    public function render()
    {
        $students = Student::all();
        return view('livewire.student.student-component',['students'=>$students])->extends('layouts.app')->section('content');
    }
}
