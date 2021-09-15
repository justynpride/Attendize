<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Organiser;
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
        $user = Auth::user();

        $organiser = Organiser::findOrFail($organiser_id);
        $groups = $organiser->groups()
            ->where('organiser_id', $organiser->id);
        
        $data = [
            'groups'    => $groups,
            'organiser' => $organiser,
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
}
