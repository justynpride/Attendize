@extends('Shared.Layouts.Master')

@section('title')
@parent
@lang("Group.group_list")
@stop


@section('page_title')
<i class="ico-users"></i>
@lang("Group.groups")
@stop

@section('top_nav')
@include('ManageOrganiser.Partials.TopNav')
@stop

@section('menu')
@include('ManageOrganiser.Partials.Sidebar')
@stop


@section('head')

@stop

@section('page_header')

<div class="col-md-9">
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="InviteAttendee" href="javascript:void(0);"  data-href="" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i> @lang("ManageEvent.invite_attendee")</button>
        </div>
        
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="ImportAttendees" href="javascript:void(0);"  data-href="" class="loadModal btn btn-success" type="button"><i class="ico-file"></i> @lang("ManageEvent.invite_attendees")</button>
        </div>
        
        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="" target="_blank" ><i class="ico-print"></i> @lang("ManageEvent.print_attendee_list")</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> @lang("ManageEvent.export") <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="">@lang("File_format.Excel_xlsx")</a></li>
                <li><a href="">@lang("File_format.Excel_xls")</a></li>
                <li><a href="">@lang("File_format.csv")</a></li>
                <li><a href="">@lang("File_format.html")</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="MessageAttendees" href="javascript:void(0);" data-href="" class="loadModal btn btn-success" type="button"><i class="ico-envelope"></i> @lang("ManageEvent.message_attendees")</button>
        </div>
    </div>
</div>
<div class="col-md-3">
   
    <div class="input-group">
        <input name="q" value="" placeholder="@lang("Group.search_groups")" type="text" class="form-control" />
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
    </div>

</div>
@stop


@section('content')

<!--Start Groups table-->
<div class="row">
 

</div>    <!--/End Groups table-->

@stop


