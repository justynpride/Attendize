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
            <button data-modal-id="NewGroup" href="javascript:void(0);"  data-href="" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i> @lang("Group.new_group")</button>
        </div>
        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="" target="_blank" ><i class="ico-print"></i> @lang("Group.print_group_list")</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> @lang("Group.export") <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="">@lang("File_format.Excel_xlsx")</a></li>
                <li><a href="">@lang("File_format.Excel_xls")</a></li>
                <li><a href="">@lang("File_format.csv")</a></li>
                <li><a href="">@lang("File_format.html")</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="MessageGroup" href="javascript:void(0);" data-href="" class="loadModal btn btn-success" type="button"><i class="ico-envelope"></i> @lang("Group.message_groups")</button>
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
  <div class="col-md-12">
        @if($groups->count())
        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                               {!!Html::sortable_link(trans("Group.name"), $sort_by, 'name', $sort_order)!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(trans("Group.town"), $sort_by, 'town', $sort_order)!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(trans("Group.country"), $sort_by, 'country_id', $sort_order)!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(trans("Group.email"), $sort_by, 'email', $sort_order)!!}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($groups as $group)
                        <tr>
                            <td>{{{$group->name}}}</td>
                            <td>
                                {{{$group->town}}}
                            </td>
                            <td>
                                {{{$group->country_id}}}
                            </td>
                            <td>
                                {{{$group->email}}}
                            </td>
                            <td class="text-center">
                                <a
                                    data-modal-id="EditAttendee"
                                    href="javascript:void(0);"
                                    data-href=""
                                    class="loadModal btn btn-xs btn-primary"
                                    > @lang("basic.edit")</a>

                                <a
                                    data-modal-id="CancelAttendee"
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

</div>    <!--/End Groups table-->

@stop


