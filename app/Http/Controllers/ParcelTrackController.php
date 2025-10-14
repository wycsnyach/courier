<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParcelTrack;
use App\Models\Parcel;
use Session;

class ParcelTrackController extends Controller
{
    public function index()
    {
        Controller::has_ability('View_Parcel_Track');
        $data['tracks'] = ParcelTrack::with('parcel')->get();
        return view('parcel_tracks.index', $data);
    }

    public function create()
    {
        Controller::has_ability('Create_Parcel_Track');
        $data['parcels'] = Parcel::all();
        return view('parcel_tracks.create', $data);
    }

    public function store(Request $request)
    {
        Controller::has_ability('Create_Parcel_Track');

        $this->validate($request, [
            'parcel_id' => 'required|exists:parcels,id',
            'status' => 'required|integer',
        ]);

        ParcelTrack::create($request->all());
        Session::flash('alert-success', 'Parcel track has been created.');
        return redirect('parcel_tracks');
    }

    public function edit($id)
    {
        Controller::has_ability('Edit_Parcel_Track');
        $data['track'] = ParcelTrack::findOrFail($id);
        $data['parcels'] = Parcel::all();
        return view('parcel_tracks.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Controller::has_ability('Edit_Parcel_Track');
        $track = ParcelTrack::findOrFail($id);

        $this->validate($request, [
            'status' => 'required|integer',
        ]);

        $track->update($request->all());
        Session::flash('alert-success', 'Parcel track has been updated.');
        return redirect('parcel_tracks');
    }

    public function destroy($id)
    {
        Controller::has_ability('Delete_Parcel_Track');
        ParcelTrack::findOrFail($id)->delete();
        Session::flash('alert-danger', 'Parcel track has been deleted.');
        return redirect('parcel_tracks');
    }
}
