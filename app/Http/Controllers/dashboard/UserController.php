<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $users)
    {
        $q = $request->input('q');

        $active = 'Users';

        $users = $users->when($q, function($query) use ($q) {
                    return $query->where('name', 'like', '%' .$q. '%')
                                 ->orwhere('email', 'like', '%' .$q. '%');
                })
        
        ->paginate(10);
          
        $request = $request->all();
        return view('dashboard/user/list', [
            'users' => $users,
            'request' => $request,
            'active' => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = USER::find($id);
        $active='Users';
        return view('dashboard/user/form', ['user'=> $user, 'active' => $active]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = USER::find($id);

        $validator = VALIDATOR::make($request->all(), [
            'name' =>  'required',
            'email' => 'required|unique:App\Models\User,email,'.$id
        ]);

        if($validator->fails()){
            return redirect('dashboard/user/edit/'.$id)
                    ->withErrors($validator)
                    ->withInput();
        }else{
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
            return redirect('dashboard/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    
        $user = USER::find($id);
        $user->delete();
        return redirect('dashboard/users');
        //
    }
}