<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Organiser;
use App\Exports\GroupsExport;
use App\Imports\GroupsImport;
use Illuminate\Http\Request;
use Auth;

class OrganiserGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateGroup(Request $request, $organiser_id)
    {
            return view('ManageOrganiser.Modals.CreateGroup', [
            'organiser' => Organiser::scope()->find($organiser_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreateGroup(Request $request, $organiser_id)
    {
        $group = Group::create();

        $group->organiser_id = $organiser_id;
        $group->name = $request->get('name');
        $group->town = $request->get('town');
        $group->email = $request->get('email');

        $group->save();

        session()->flash('message', 'Successfully Created Group');

        return response()->json([
            'status'      => 'success',
            'id'          => $group->id,
            'message'     => trans("Controllers.refreshing"),
            'redirectUrl' => route('showOrganiserGroups', [
            'organiser_id' => $organiser_id,
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOrganiserGroups(Request $request, $organiser_id)
    {

        $organiser = Organiser::findOrFail($organiser_id);
        $allowed_sorts = ['created_at', 'name', 'town', 'email'];

        $searchQuery = $request->get('q');
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'town');
        
       $groups = $organiser->groups();                 
       if ($searchQuery) {
            $groups->where('town', 'like', '%' . $searchQuery . '%');
        }            
        
        $data = [
            'groups'    => $groups,
            'organiser' => $organiser,
            'search' => [
                'q' => $searchQuery ? $searchQuery : '',
                'sort_by' => $request->get('sort_by') ? $request->get('sort_by') : '',           
            ],
        ];

        return view('ManageOrganiser.Groups', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function showExportGroups($organiser_id, $export_as = 'xls')
    {
        $organiser = Organiser::scope()->findOrFail($organiser_id);
        $date = date('d-m-Y-g.i.a');
        return (new GroupsExport($organiser->id))->download("groups-as-of-{$date}.{$export_as}");
    }

    /**
     * Show the printable group list
     *
     * @param $event_id
     * @return View
     */
    public function showPrintGroups($organiser_id)
    {
        $data['organiser'] = Organiser::scope()->find($organiser_id);
        $data['groups'] = $data['organiser']->groups()->orderBy('name')->get();

        return view('ManageOrganiser.PrintGroups', $data);
    }    
}
