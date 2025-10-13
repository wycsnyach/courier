<?php

namespace App\Http\Controllers;

use App\Models\Paymentmode;
use Illuminate\Http\Request;
use Bouncer;
use Session;
use Auth;
use DB;

class PaymentmodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Bouncer::cannot('View_Paymentmode')){    
           Session::flash('alert-danger', 'You are not allowed');
           return redirect()->back();           
        } 

        $data['paymentmodes']=Paymentmode::all();
        return view('paymentmodes.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Bouncer::cannot('Create_Paymentmode')){    
           Session::flash('alert-danger', 'You are not allowed');
           return redirect()->back();           
        } 
        return view('paymentmodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
             if(Bouncer::cannot('Create_Paymentmode')){    
           Session::flash('alert-danger', 'You are not allowed');
           return redirect()->back();           
        }
         $this->validate($request,[           
            'name' => 'required',
            'description' => 'required',
            
                        
        ]);

         $paymentmode=Paymentmode::create([
                                'name'=>$request->name,
                                'description'=>$request->description,
                                
                            ]); 

       
        return redirect('paymentmodes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\paymentmode  $paymentmode
     * @return \Illuminate\Http\Response
     */
    public function show(Paymentmode $paymentmode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\paymentmode  $paymentmode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         if(Bouncer::cannot('Edit_Paymentmode')){    
           Session::flash('alert-danger', 'You are not allowed');
           return redirect()->back();           
        } 

        $data['paymentmode']=Paymentmode::find($id);

        return view('paymentmodes.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\paymentmode  $paymentmode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
           if(Bouncer::cannot('Edit_Paymentmode')){    
           Session::flash('alert-danger', 'You are not allowed');
           return redirect()->back();           
        }

            $paymentmode=Paymentmode::find($id);
            $this->validate($request,[           
                'name' => 'required',
                'description' => 'required',
               
            ]);


        $paymentmode->update($request->all());
        return redirect('paymentmodes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\paymentmode  $paymentmode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
           if(Bouncer::cannot('Delete_Paymentmode')){    
           Session::flash('alert-danger', 'You are not allowed');
           return redirect()->back();           
        } 
        Paymentmode::find($id)->delete();

        return redirect('paymentmodes');
    }
}
