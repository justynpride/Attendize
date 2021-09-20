<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Organiser;
use App\Jobs\SendMessageToAttendeesJob;
use App\Models\Message;
use App\Exports\GroupsExport;
use App\Imports\GroupsImport;
use Illuminate\Http\Request;
use Auth;
use Mail;

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

    /**
     * Show the 'Import Group' modal
     *
     * @param Request $request
     * @param $organiser_id
     * @return string|View
     */
    public function showImportGroups(Request $request, $organiser_id)
    {
        $organiser = Organiser::scope()->find($organiser_id);

        return view('ManageOrganiser.Modals.ImportGroups', [
            'organiser'   => $organiser,
        ]);
    }


    /**
     * Import groups
     *
     * @param Request $request
     * @param $organiser_id
     * @return mixed
     */
    public function postImportGroups(Request $request, $organiser_id)
    {
        $rules = [
            'groups_list' => 'required|mimes:csv,txt|max:5000|',
        ];


        $organiser = Organiser::findOrFail($organiser_id);
        if ($request->file('groups_list')) {
            (new GroupsImport($organiser))->import(request()->file('groups_list'));
        }

        session()->flash('message', 'Groups Successfully Imported');

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => route('showOrganiserGroups', [
                'organiser_id' => $organiser_id,
            ]),
        ]);
    }

    public function showMessageGroup(Request $request, $group_id)
    {
        $group = Group::scope()->findOrFail($group_id);

        $data = [
            'group' => $group,
            'organiser'    => $group->organiser,
        ];

        return view('ManageOrganiser.Modals.MessageGroup', $data);
    }

    /**
     * Send a message to an attendee
     *
     * @param Request $request
     * @param $group_id
     * @return mixed
     */
    public function postMessageGroup(Request $request, $group_id)
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

        $group = Group::scope()->findOrFail($group_id);

        $data = [
            'group'        => $group,
            'message_content' => $request->get('message'),
            'subject'         => $request->get('subject'),
            'organiser'           => $group->organiser
        ];

        //@todo move this to the SendAttendeeMessage Job
        Mail::send(Lang::locale().'.Emails.messageReceived', $data, function ($message) use ($group, $data) {
            $message->to($group->email, $group->name)
                ->from(config('attendize.outgoing_email_noreply'), $group->organiser->name)
                ->replyTo($group->organiser->email, $group->organiser->name)
                ->subject($data['subject']);
        });

        /* Could bcc in the above? */
        if ($request->get('send_copy') == '1') {
            Mail::send(Lang::locale().'.Emails.messageReceived', $data, function ($message) use ($group, $data) {
                $message->to($group->organiser->email, $group->organiser->name)
                    ->from(config('attendize.outgoing_email_noreply'), $group->organiser->name)
                    ->replyTo($group->organiser->email, $group->organiser->name)
                    ->subject($data['subject'] . trans("Email.organiser_copy"));
            });
        }

        return response()->json([
            'status'  => 'success',
            'message' => trans("Controllers.message_successfully_sent"),
        ]);
    }

    /**
     * Shows the 'Message Groups' modal
     *
     * @param $event_id
     * @return View
     */
    public function showMessageGroups(Request $request, $organiser_id)
    {
        $data = [
            'organiser'   => Organiser::scope()->find($organiser_id),
        ];

        return view('ManageOrganiser.Modals.MessageGroups', $data);
    }

    /**
     * Send a message to groups
     *
     * @param Request $request
     * @param $organiser_id
     * @return mixed
     */
    public function postMessageAttendees(Request $request, $organiser_id)
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
            
}
