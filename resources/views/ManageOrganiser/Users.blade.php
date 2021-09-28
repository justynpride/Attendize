@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang("basic.dashboard")
@stop


@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop

@section('page_title')
<i class="ico-group"></i>
{{ trans('Organiser.users', ['name'=>$organiser->name]) }}
@endsection

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('head')

@stop

@section('page_header')

<div class="col-md-9">
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="CreateUser" href="javascript:void(0);"  data-href="" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i> @lang("User.create_user")</button>
        </div>
        
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="ImportUsers" href="javascript:void(0);"  data-href="{{route('showImportUsers', ['organiser_id'=>$organiser->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-file"></i> @lang("User.import_users")</button>
        </div>
        
        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="{{route('showPrintUsers', ['organiser_id'=>$organiser->id])}}" target="_blank" ><i class="ico-print"></i> @lang("Organiser.print_user_list")</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> @lang("Organiser.export") <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('showExportUsers', ['organiser_id'=>$organiser->id,'export_as'=>'xlsx'])}}">@lang("File_format.Excel_xlsx")</a></li>
                <li><a href="{{route('showExportUsers', ['organiser_id'=>$organiser->id,'export_as'=>'xls'])}}">@lang("File_format.Excel_xls")</a></li>
                <li><a href="{{route('showExportUsers', ['organiser_id'=>$organiser->id,'export_as'=>'csv'])}}">@lang("File_format.csv")</a></li>
                <li><a href="{{route('showExportUsers', ['organiser_id'=>$organiser->id,'export_as'=>'html'])}}">@lang("File_format.html")</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="MessageUsers" href="javascript:void(0);" data-href="{{route('showMessageUsers', ['organiser_id'=>$organiser->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-envelope"></i> @lang("Organiser.message_users")</button>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="input-group">
        <input name="q" value="" placeholder="@lang("Organiser.search_users")" type="text" class="form-control" />
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
    </div>
</div>
@stop

@section('content')

<!--Start Users table-->
<div class="row">
    <div class="col-md-12">
        @if($users->count())
        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                               @lang("User.first_name")
                            </th>
                            <th>
                               @lang("User.last_name")
                            </th>
                            <th>
                               @lang("User.email")
                            </th>
                            <th>
                               @lang("User.role")
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="user_{{$user->id}}">
                            <td>{{{$user->first_name}}}</td>
                            <td>
                                {{{$user->last_name}}}
                            </td>
                            <td>
                                <a data-modal-id="MessageUser" href="javascript:void(0);" class="loadModal"
                                    data-href="{{route('showMessageUser', ['organiser_id'=>$organiser->id, 'id' => $user->id])}}"
                                    > {{$user->email}}</a>
                            </td>
                            <td>
                                {{$user->id}}
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang("basic.action") <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @if($user->email)
                                        <li><a
                                            data-modal-id="MessageAttendee"
                                            href="javascript:void(0);"
                                            data-href="{{route('showMessageUser', ['organiser_id'=>$organiser->id, $user->id])}}"
                                            class="loadModal"
                                            > @lang("basic.message")</a></li>
                                        @endif
                                    </ul>
                                </div>
                                <a
                                    data-modal-id="EditUser"
                                    href="javascript:void(0);"
                                    data-href="{{route('showEditOrganiserUser', ['organiser_id'=>$organiser->id, $user->id])}}"
                                    class="loadModal btn btn-xs btn-primary"
                                    > @lang("basic.edit")</a>

                                <a
                                    data-modal-id="EditUser"
                                    href="javascript:void(0);"
                                    data-href="{{route('organiserUserDelete', ['organiser_id'=>$organiser->id, $user->id])}}"
                                    class="loadModal btn btn-xs btn-danger"
                                    > @lang("basic.cancel")</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else

        @if(!empty($q))
        @include('Shared.Partials.NoSearchResults')
        @else
        @include('ManageOrganiser.Partials.UsersBlankSlate')
        @endif

        @endif
    </div>
    <div class="col-md-12">
        
    </div>
</div>    <!--/End users table-->

@stop