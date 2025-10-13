<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Bouncer;
use Session;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         Controller::has_ability('View_Status');
      $data['statuses']=Status::all();
    
      return view('statuses.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Controller::has_ability('Create_Status');
        return view('statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $this->validate($request,[           
         
         'name' => 'required|string|max:255|unique:statuses',
            
        ]);

        Status::create($request->all());
        Session::flash('alert-success', 'Status has been Created');
        return redirect('statuses');
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
        Controller::has_ability('Edit_Status');
        $status=Status::find($id);

        
        $data['status']=$status;

        return view('statuses.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Controller::has_ability('Edit_Status');
        $status=Status::find($id); 

        $this->validate($request,[           
            'name' => 'required|string|max:255',
           
            
        ]);

        $status->update($request->all());
        Session::flash('alert-success', 'Status has been updated');

        return redirect('statuses'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Controller::has_ability('Delete_Status');
         $status=Status::find($id);
         $status->delete();

        Session::flash('alert-danger', 'Status has been deleted');

         return redirect('statuses');
    }
}
