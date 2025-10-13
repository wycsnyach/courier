<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Mo;
use Bouncer;
use Session;

class RolesController extends Controller
{
      
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
    public function index()
    {
       
      Controller::has_ability('View_Role');

      $data['roles']=Role::all();
      return view('roles.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      Controller::has_ability('Create_Role');

        $data['mos']=Mo::all();
        return view('roles.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      /* Controller::has_ability('Create_Role');
        $roles_count = Role::count() ;
        if ( $roles_count <=4  ) { 
       $role=Bouncer::Role()->firstOrCreate([
            'name' => $request->rolename,
            'title' => $request->rolename,
        ]); 

              
      Session::flash('alert-success', 'Role created');

     return redirect('roles/'.$role->id.'/edit');
         }
        else {
            Session::flash('info', 'Please delete some roles, max: 10') ;
            return redirect('roles');       
        }*/

      Controller::has_ability('Create_Role');
        
       $role=Bouncer::Role()->firstOrCreate([
            'name' => $request->rolename,
            'title' => $request->rolename,
        ]); 

              
      Session::flash('alert-success', 'Role created');

     return redirect('roles/'.$role->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       Controller::has_ability('View_Role');

        $data['role']=Role::find($id);
        $data['mos']=Mo::all();

        return view('roles.view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       Controller::has_ability('Edit_Role');
        $data['role']=Role::find($id);
        $data['mos']=Mo::all();

        return view('roles.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */

    public function update_role(Request $request)
    {
       Controller::has_ability('Edit_Role');

        $role= Bouncer::role()->find($request->role_id);


       $role->update([
            'name' => $request->rolename,
            'title' => $request->rolename,
        ]);

  

        
    }
   public function update_permission(Request $request)
    {
       Controller::has_ability('Edit_Role');

        $role= Bouncer::role()->find($request->role_id);

        if(Controller::can_model($request->model,$request->action,$role)=="checked"){

             $ability = Bouncer::ability()->firstOrCreate([
                    'name' => $request->action."_".$request->model,
                    'title' =>$request->action." ".$request->model,
                ]);    

             Bouncer::disallow($role)->to($ability);


        }else{

            $ability = Bouncer::ability()->firstOrCreate([
                    'name' => $request->action."_".$request->model,
                    'title' =>$request->action." ".$request->model,
                ]);

             Bouncer::allow($role)->to($ability);

        }


        
    }




    public function update(Request $request,$id)
    {
       //Controller::has_ability('Edit_Role');

       // $role= Bouncer::role()->find($id);
             
  
      // Bouncer::sync($role)->abilities([]);

      /*foreach($request->mo as $mo){
        
        Bouncer::allow($role)->toOwn('App\\'.$mo)->to($request->$mo);        

       } */

       /* $models=$request->mo;
        foreach($models as $model){

        //return $request->$model;

        //Bouncer::allow($role)->toOwn('App\\'.$mo)->to($request->$mo);

          foreach($request->$model as $action){

                $ability = Bouncer::ability()->firstOrCreate([
                    'name' => $action."_".$model,
                    'title' =>$action." ".$model,
                ]);

                Bouncer::allow($role)->to($ability);
             }

       } */
  
        
       // Session::flash('alert-success', 'Role Update');

     // return redirect('roles');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
      Controller::has_ability('Delete_Role'); 

       $role= Bouncer::role()->find($id);
  
       Bouncer::sync($role)->abilities([]);

       $role->delete();

        Session::flash('alert-success', 'Deleted');

        return redirect('roles');
    }


    
}
