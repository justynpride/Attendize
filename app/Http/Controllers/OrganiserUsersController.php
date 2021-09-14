<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organiser;
use Auth;
use Illuminate\Http\Request;

class OrganiserUsersController extends Controller
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
     * Show the organiser users page
     *
     * @param Request $request
     * @param $organiser_id
     * @return mixed
     */
    public function showUsers(Request $request, $organiser_id)
    {
        $user = Auth::user();
        
        $organiser = Organiser::findOrFail($organiser_id);
        $allowed_sorts = ['created_at', 'last_name', 'first_name', 'email'];

        $searchQuery = $request->get('q');
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'last_name');

        // If user can manage users, then they can see all users, otherwise just their own
        $users = $organiser->users()
            ->where('organiser_id', $organiser->id)
            ->orderBy($sort_by, 'desc');
            
       if ($searchQuery) {
            $users->where('last_name', 'like', '%' . $searchQuery . '%');
        }

        $data = [
            'users' => $users->paginate(12),
            'organiser' => $organiser,
            'search' => [
                'q' => $searchQuery ? $searchQuery : '',
                'sort_by' => $request->get('sort_by') ? $request->get('sort_by') : '',
                'showPast' => $request->get('past'),
            ],
        ];

        return view('ManageOrganiser.Users', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEditOrganiserUser(Request $request, $organiser_id, $id)
    { 
        $user = User::find($id);
        return view('ManageOrganiser.Modals.EditUser', compact( 'user' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postEditOrganiserUser(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMessageUser(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Modals.MessageUser');
    }    
    
      /**
     * Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postMessageUser(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Users');
    } 

     /** Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMessageUsers(Request $request, $organiser_id)
    {
    
        return view('ManageOrganiser.Modals.MessageUsers');
    }    
    
    /**
     * Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postMessageUsers(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Users');
    }     

    /**
     * Delete users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function organiserUserDelete(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Modals.CancelUser');
    }    

    /**
     * Restore user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function organiserUserRestore(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Users');
    }    

    /**
     * Invite user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function organiserSendInvitationMessage(Request $request, $organiser_id)
    {
        return view('ManageOrganiser.Users');
    }    
}
