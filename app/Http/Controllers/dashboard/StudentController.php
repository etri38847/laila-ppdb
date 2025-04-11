<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Student $students)
    {
        $q = $request->input('q');

        $active = 'Students';

        $students = $students->when($q, function($query) use ($q) {
                    return $query->where('namasiswa', 'like', '%' .$q. '%')
                                 ->orwhere('email', 'like', '%' .$q. '%');
                })
        
        ->paginate(10);

        $request = $request->all();
        return view('dashboard/Student/list', [
            'students' => $students,
            'request' => $request,
            'active' => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active = 'Students';
        return view('dashboard/Student/form', [
            'active' => $active,
            'button' =>'Create',
            'url'    =>'dashboard.students.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn'          => 'required',
            'namasiswa'     => 'required|unique:App\Models\Student,namasiswa',
            'tanggallahir'  => 'required',
            'alamat'        => 'required',
            'nmrtelepon'    => 'required',
            'jeniskelamin'  => 'required',
            'email'         => 'required',
            'thumbnail'     => 'required|image',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.students.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $student = new Student(); //Tambahkan  ini untuk membuat objek Student
            $image = $request->file('thumbnail');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/student', $image, $filename);

            $student->nisn = $request->input('nisn');
            $student->namasiswa = $request->input('namasiswa');
            $student->tanggallahir = $request->input('tanggallahir');
            $student->alamat = $request->input('alamat');
            $student->nmrtelepon = $request->input('nmrtelepon');
            $student->jeniskelamin = $request->input('jeniskelamin');
            $student->email = $request->input('email');
            $student->thumbnail = $filename; // Ganti dengan nama file yang baru  diupload
            $student->save();

            return redirect()
                        ->route('dashboard.students')
                        ->with('message', __('messages.store', ['namasiswa'=>$request->input('namasiswa')]));

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
        $active = 'Students';
        return view('dashboard/Student/form', [
            'active'  => $active,
            'student' =>$student,
            'button'  =>'Update',
            'url'     =>'dashboard.students.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
        $validator = Validator::make($request->all(), [
            'nisn'          => 'required',
            'namasiswa'     => 'required|unique:App\Models\Student,namasiswa',
            'tanggallahir'  => 'required',
            'alamat'        => 'required',
            'nmrtelepon'    => 'required',
            'jeniskelamin'  => 'required',
            'email'         => 'required',
            'thumbnail'     => 'required|image'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.students.update', $student->nisn)
                ->withErrors($validator)
                ->withInput();
        } else {
            // $student = new Student(); // Tambahkan ini untuk membuat objek Student
                if($request->hasFile('thumbnail')){
                    $image = $request->file('thumbnail');
                    $filename = time() .'.'. $image->getClientOriginalExtension();
                        Storage::disk('local')->putFileAs('public/student', $image, $filename);
                    $student->thumbnail = $filename; // Ganti dengan nama fle yang baru diupload
                }
            $student->nisn = $request->input('nisn');
            $student->namasiswa = $request->input('namasiswa');
            $student->tanggallahir = $request->input('tanggallahir');
            $student->alamat = $request->input('alamat');
            $student->nmrtelepon = $request->input('nmrtelepon');
            $student->jeniskelamin = $request->input('jeniskelamin');
            $student->email = $request->input('email');
            $student->save();

            return redirect()
                            ->route('dashboard.students')
                            ->with('message',__('messages.update', ['namasiswa'=>$request->input('namasiswa')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $namasiswa = $student->namasiswa;

        $student->delete();
        return redirect()
                ->route('dashboard.students')
                ->with('message', __('messages.delete', ['namasiswa' => $namasiswa]));
    }
}
