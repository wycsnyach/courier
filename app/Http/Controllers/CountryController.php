<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Bouncer;
use Session;

use Auth;
use DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Controller::has_ability('View_Country');
      $data['countries']=Country::all();
    
      return view('countries.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Controller::has_ability('Create_Country');
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          $this->validate($request,[           
         'ccode' => 'required|string|max:255|unique:countries',
         'name' => 'required|string|max:255|unique:countries',
            
        ]);

        Country::create($request->all());
        Session::flash('alert-success', 'Country has been Created');
        return redirect('countries');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
       /*   Controller::has_ability('View_Country');
  

        $data['country']=$country;

        return view('countries.show',$data);*/
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit($id)
    {
        
        Controller::has_ability('Edit_Country');
        $country=Country::find($id);

        
        $data['country']=$country;

        return view('countries.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       Controller::has_ability('Edit_Country');
        $country=Country::find($id); 

        $this->validate($request,[           
            'name' => 'required|string|max:255',
            'ccode' => 'required',
            
            
        ]);

        $country->update($request->all());
        Session::flash('alert-success', 'Country has been updated');

        return redirect('countries'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Controller::has_ability('Delete_Country');
         $country=Country::find($id);
         $country->delete();

        Session::flash('alert-danger', 'User has been deleted');

         return redirect('countries');
   
    }


    /*UPLOAD FUNCTION START*/

        public function upload()
    {
        Controller::has_ability('Create_Country');
        return view('countries.import');

    }
    /*END*/

    /*UPLOAD CODE START*/

    public function post_upload_countries(Request $request)
    {

         $this->validate($request,[      
            
            'csv_file'=>'required'
        ]);   

        $columns=['name','ccode'];        

        if($file = $request->file('csv_file')){

            $extension = $file->getClientOriginalExtension();

            if($extension!='csv'&& $extension!='CSV'){

              Session::flash('alert-danger','Provide a csv format file');

              return redirect()->back();

            }else{
              
              $path=Controller::upload_file($file);

              
             /* if($path==1){

                 Session::flash('alert-danger','The file with the same name exists.please rename the file and try again.');

                 return redirect()->back();
              }*/

             
             
              if (($handle = fopen($path, 'r')) !== false){$cols= fgetcsv($handle); }           

                $missing='';

                foreach($columns as $column){
                  if(!in_array( $column, $cols)){
                        $missing.= $column.",";     
                  }
                }


              if ($missing!=''){

                Session::flash('alert-danger', 'Your csv file is missing '.$missing);        
              
                return redirect()->back();

              }else{

            $files_updated=0;

              $header = null;
              $data = array();
                if (($handle = fopen($path, 'r')) !== false)
                {
                   while (($r= fgetcsv($handle)) !== false)
                   {
                      if (!$header){
                        $header = $r;
                      }else
                        {  

                            $row= array_combine($header, $r);                        
                            $matchThese=['name'=>$row['name']];

                            Country::updateOrCreate($matchThese,
                                            [ 
                                              'name'=>$row['name'],
                                              'ccode'=>$row['ccode']
                                             ]);            

                     
                        }
                      $files_updated++;               


                    }//end while
                }   
                fclose($handle);             


                Session::flash('alert-info', 'You have successfully updated '.$files_updated.' records');
                return redirect()->back(); 

              }


            }     
              
         }else{

            Session::flash('alert-danger', 'You have not added a file');
         
            return redirect()->back();
         } 


    }
    /*END*/

}
