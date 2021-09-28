<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organiser;
use Auth;
use App\Jobs\SendMessageToUsersJob;
use App\Models\Message;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
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
     public function showCreateUser(Request $request, $organiser_id)
    {
            return view('ManageOrganiser.Modals.CreateUser', [
            'organiser' => Organiser::scope()->find($organiser_id, ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreateUser(Request $request, $organiser_id)
    {
        $user = User::create();
        $organiser = Organiser::findOrFail($organiser_id);

        $user->organiser_id = $organiser_id;
        $user->account_id = $organiser->account_id;
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');

        $user->save();

        session()->flash('message', 'Successfully Created User');

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
    public function postEditOrganiserUser(Request $request, $organiser_id, $id)
    {

        $user = User::find($id);
        
        $user->first_name       = $request->input('first_name');
        $user->last_name       = $request->input('last_name');        
        $user->email        = $request->input('email');
        $user->save();
        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('ManageOrganiser.Users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
        public function showExportUsers($organiser_id, $export_as = 'xls')
    {
        $organiser = Organiser::scope()->findOrFail($organiser_id);
        $date = date('d-m-Y-g.i.a');
        return (new UsersExport($organiser->id))->download("users-as-of-{$date}.{$export_as}");
    }

    /**
     * Show the printable group list
     *
     * @param $event_id
     * @return View
     */
    public function showPrintUsers($organiser_id)
    {
        $data['organiser'] = Organiser::scope()->find($organiser_id);
        $data['users'] = $data['organiser']->users()->orderBy('last_name')->get();

        return view('ManageOrganiser.PrintUsers', $data);
    }

    /**
     * Show the 'Import Group' modal
     *
     * @param Request $request
     * @param $organiser_id
     * @return string|View
     */
    public function showImportUsers(Request $request, $organiser_id)
    {
        $organiser = Organiser::scope()->find($organiser_id);

        return view('ManageOrganiser.Modals.ImportUser', [
            'organiser'   => $organiser,
        ]);
    }
    
       /**
     * Import users
     *
     * @param Request $request
     * @param $organiser_id
     * @return mixed
     */
    public function postImportUsers(Request $request, $organiser_id)
    {
        $rules = [
            'users_list' => 'required|mimes:csv,txt|max:5000|',
        ];


        $organiser = Organiser::findOrFail($organiser_id);
        if ($request->file('users_list')) {
            (new UsersImport($organiser))->import(request()->file('users_list'));
        }

        session()->flash('message', 'Users Successfully Imported');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showOrganiserUsers', [
                'organiser_id' => $organiser_id,
            ]),
        ]);
    }
    
    /**
     * Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMessageUser(Request $request, $organiser_id, $id)
    {
        $user = User::scope()->findOrFail($user_id);

        $data = [
            'user' => $user,
            'organiser'    => $user->organiser,
        ];

        return view('ManageOrganiser.Modals.MessageUser');
    }    
    
      /**
     * Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postMessageUser(Request $request, $organiser_id, $id)
    {
        $rules = [
            'subject' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $user = User::scope()->findOrFail($user_id);

        $data = [
            'user'        => $user,
            'message_content' => $request->get('message'),
            'subject'         => $request->get('subject'),
            'organiser'           => $user->organiser
        ];

        //@todo move this to the SendAttendeeMessage Job
        Mail::send(Lang::locale().'.Emails.messageReceived', $data, function ($message) use ($user, $data) {
            $message->to($user->email, $user->name)
                ->from(config('attendize.outgoing_email_noreply'), $user->organiser->name)
                ->replyTo($user->organiser->email, $user->organiser->name)
                ->subject($data['subject']);
        });

        /* Could bcc in the above? */
        if ($request->get('send_copy') == '1') {
            Mail::send(Lang::locale().'.Emails.messageReceived', $data, function ($message) use ($user, $data) {
                $message->to($user->organiser->email, $user->organiser->name)
                    ->from(config('attendize.outgoing_email_noreply'), $user->organiser->name)
                    ->replyTo($user->organiser->email, $user->organiser->name)
                    ->subject($data['subject'] . trans("Email.organiser_copy"));
            });
        }

        return response()->json([
            'status'  => 'success',
            'message' => trans("Controllers.message_successfully_sent"),
        ]);
    } 

     /** Message users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMessageUsers(Request $request, $organiser_id)
    {
        $data = [
            'organiser'   => Organiser::scope()->find($organiser_id),
        ];
    
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
        $rules = [
            'subject'    => 'required',
            'message'    => 'required',
            'recipients' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $message = Message::createNew();
        $message->message = $request->get('message');
        $message->subject = $request->get('subject');
        $message->recipients = ($request->get('recipients') == 'all') ? 'all' : $request->get('recipients');
        $message->organiser_id = $organiser_id;
        $message->save();

        /*
         * Queue the emails
         */
        SendMessageToGroupsJob::dispatch($message);

        return response()->json([
            'status'  => 'success',
            'message' => 'Message Successfully Sent',
        ]);
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
