<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Country;
use Session;

class BranchController extends Controller
{
    /**
     * Display a listing of the branches.
     */
    public function index()
    {
        Controller::has_ability('View_Branch');

        $data['branches'] = Branch::select('branches.*', 'countries.name as country_name')
            ->leftJoin('countries', 'countries.id', '=', 'branches.country_id')
            ->orderBy('branches.created_at', 'desc')
            ->get();

        return view('branches.index', $data);
    }


    /**
     * Show the form for creating a new branch.
     */
    public function create()
    {
        Controller::has_ability('Create_Branch');
        $data['countries'] = Country::all();
        return view('branches.create', $data);
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(Request $request)
    {
        Controller::has_ability('Create_Branch');

        $this->validate($request, [
            'branch_code' => 'required|string|max:50|unique:branches,branch_code',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'contact' => 'required|string|max:100',
        ]);

        Branch::create($request->all());

        Session::flash('alert-success', 'Branch has been created successfully.');
        return redirect()->route('branches.index');
    }

    /**
     * Show the form for editing the specified branch.
     */
    public function edit($id)
    {
        Controller::has_ability('Edit_Branch');
        $data['branch'] = Branch::findOrFail($id);
        $data['countries'] = Country::all();
        return view('branches.edit', $data);
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(Request $request, $id)
    {
        Controller::has_ability('Edit_Branch');

        $branch = Branch::findOrFail($id);

        $this->validate($request, [
            'branch_code' => 'required|string|max:50|unique:branches,branch_code,' . $branch->id,
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'contact' => 'required|string|max:100',
        ]);

        $branch->update($request->all());

        Session::flash('alert-success', 'Branch has been updated successfully.');
        return redirect()->route('branches.index');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy($id)
    {
        Controller::has_ability('Delete_Branch');
        $branch = Branch::findOrFail($id);
        $branch->delete();

        Session::flash('alert-danger', 'Branch has been deleted successfully.');
        return redirect()->route('branches.index');
    }


         /*TOTAL Branches*/
        public function branches_count()
        {

            return Branch::count();

        }
    /*END*/
}
