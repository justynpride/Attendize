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
            <button data-modal-id="CreateGroup" href="javascript:void(0);"  data-href="{{route('showCreateGroup', ['organiser_id'=>$organiser->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i> @lang("Group.create_group")</button>
        </div>
        
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="ImportGroups" href="javascript:void(0);"  data-href="" class="loadModal btn btn-success" type="button"><i class="ico-file"></i> @lang("Group.import_groups")</button>
        </div>
        
        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="{{route('showPrintGroups', ['organiser_id'=>$organiser->id])}}" target="_blank" ><i class="ico-print"></i> @lang("Group.print_group_list")</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> @lang("Group.export") <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('showExportGroups', ['organiser_id'=>$organiser->id,'export_as'=>'xlsx'])}}">@lang("File_format.Excel_xlsx")</a></li>
                <li><a href="{{route('showExportGroups', ['organiser_id'=>$organiser->id,'export_as'=>'xlsx'])}}">@lang("File_format.Excel_xls")</a></li>
                <li><a href="{{route('showExportGroups', ['organiser_id'=>$organiser->id,'export_as'=>'xlsx'])}}">@lang("File_format.csv")</a></li>
                <li><a href="{{route('showExportGroups', ['organiser_id'=>$organiser->id,'export_as'=>'xlsx'])}}">@lang("File_format.html")</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="MessageUsers" href="javascript:void(0);" data-href="" class="loadModal btn btn-success" type="button"><i class="ico-envelope"></i> @lang("Group.message_groups")</button>
        </div>
    </div>
</div>
<div class="col-md-3">
   {!! Form::open(array('url' => route('showOrganiserGroups', ['organiser_id'=>$organiser->id]), 'method' => 'get')) !!}
    <div class="input-group">
        <input name="q" value="" placeholder="@lang("Group.search_groups")" type="text" class="form-control" />
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
    </div>
   {!! Form::close() !!} 
</div>
@stop

@section('content')

<!--Start Groups table-->
<div class="row">
    <div class="col-md-12">
        @if($groups->count())
        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                               @lang("Group.name")
                            </th>
                            <th>
                               @lang("Group.town")
                            </th>
                            <th>
                               @lang("Group.email")
                            </th>
                            <th>
                               @lang("Group.country")
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr class="group_{{$group->id}}">
                            <td>{{{$group->name}}}</td>
                            <td>
                                {{{$group->town}}}
                            </td>
                            <td>
                                <a data-modal-id="MessageGroup" href="javascript:void(0);" class="loadModal"
                                    data-href=""
                                    > {{$group->email}}</a>
                            </td>
                            <td>
                                {{$group->country_id}}
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang("basic.action") <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @if($group->email)
                                        <li><a
                                            data-modal-id="MessageAttendee"
                                            href="javascript:void(0);"
                                            data-href=""
                                            class="loadModal"
                                            > @lang("basic.message")</a></li>
                                        @endif
                                    </ul>
                                </div>
                                <a
                                    data-modal-id="EditGroup"
                                    href="javascript:void(0);"
                                    data-href=""
                                    class="loadModal btn btn-xs btn-primary"
                                    > @lang("basic.edit")</a>

                                <a
                                    data-modal-id="EditUser"
                                    href="javascript:void(0);"
                                    data-href=""
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
        @include('ManageOrganiser.Partials.GroupsBlankSlate')
        @endif

        @endif
    </div>
    <div class="col-md-12">
        
    </div>
</div>    <!--/End groups table-->

@stop
