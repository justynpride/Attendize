<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Group;
use App\Models\Organiser;
use App\Http\Requests\StoreOrganiserGroupRequest;
use Illuminate\Http\Request;
use Auth;
use Config;
use DB;
use Excel;
use Exception;
use Log;
use Mail;
use PDF;
use Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Scope;

class OrganiserGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($organiser_id)
    {
        $organiser = Organiser::scope()->findOrfail($organiser_id);
        $groups = Group::all();

        return view('ManageOrganiser.Groups', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $organiser_id)
    {
        $allowed_sorts = ['name', 'town', 'country_id', 'email'];

        $searchQuery = $request->get('q');
        $sort_order = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');

        $organiser = Organiser::scope()->find($organiser_id);
$groups = Group::all();
      /*  if ($searchQuery) {
            $groups = Group::scope()->find($organiser)
                ->join('countries', 'countries.id', '=', 'group.country_id')
                ->where(function ($query) use ($searchQuery) {
                    $query->where('group.country_id', 'like', $searchQuery . '%')
                        ->orWhere('group.name', 'like', $searchQuery . '%')
                        ->orWhere('group.town', 'like', $searchQuery . '%')
                        ->orWhere('group.email', 'like', $searchQuery . '%');
                })
                ->orderBy(($sort_by == 'name' ? 'orders.' : 'groups.') . $sort_by, $sort_order)
                ->select('groups.*', 'groups_id')
                ->paginate();
        } else {
            $groups = Group::scope()->find($organiser_id)
            ->join('countries', 'countries.id', '=', 'group.country_id')
                ->orderBy(($sort_by == 'name' ? 'orders.' : 'groups.') . $sort_by, $sort_order)
                ->select('groups.*', 'groups_id')
                ->paginate();
        }
*/
        $data = [
            'groups'  => $groups,
            'organiser'      => $organiser,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
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
