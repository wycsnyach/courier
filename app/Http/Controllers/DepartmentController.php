<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Bouncer;
use Session;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    Controller::has_ability('View_Department');
      $data['departments']=Department::all();
    
      return view('departments.index',$data);
    }

   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Controller::has_ability('Create_Department');
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $this->validate($request,[           
         
         'name' => 'required|string|max:255|unique:departments',
         'dcode' => 'required|string|max:255|unique:departments',
            
        ]);

        Department::create($request->all());
        Session::flash('alert-success', 'Department has been Created');
        return redirect('departments');
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
        Controller::has_ability('Edit_Department');
        $department=Department::find($id);

        
        $data['department']=$department;

        return view('departments.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Controller::has_ability('Edit_Department');
        $department=Department::find($id); 

        $this->validate($request,[           
            'name' => 'required|string|max:255',
            'dcode' => 'required',
           
            
        ]);

        $department->update($request->all());
        Session::flash('alert-success', 'Department has been updated');

        return redirect('departments'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Controller::has_ability('Delete_Department');
         $department=Department::find($id);
         $department->delete();

        Session::flash('alert-danger', 'Department has been deleted');

         return redirect('departments');
    }

    /*TOTAL DEPARTMENTS*/
        public function departments_count()
    {

        return Department::count();

    }
    /*END*/


    /*UPLOAD FUNCTION START*/

        public function upload()
    {
        Controller::has_ability('Create_Department');
        return view('departments.import');

    }
    /*END*/

    /*UPLOAD CODE START*/

    public function post_upload_departments(Request $request)
    {

         $this->validate($request,[      
            
            'csv_file'=>'required'
        ]);   

        $columns=['name','dcode'];        

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

                            Department::updateOrCreate($matchThese,
                                            [ 
                                              'name'=>$row['name'],
                                              'dcode'=>$row['dcode']
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
