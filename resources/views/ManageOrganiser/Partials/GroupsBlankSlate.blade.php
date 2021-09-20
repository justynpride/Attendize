@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-users
@stop

@section('blankslate-title')
    @lang("Group.no_groups_yet")
@stop

@section('blankslate-text')
    @lang("Group.no_groups_yet_text")
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id='CreateGroup' data-href="{{route('showCreateGroup', ['organiser_id'=>$organiser->id])}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
    <i class="ico-user-plus"></i>
    @lang("Group.create_group")
</button>
@stop


