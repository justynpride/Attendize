@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    @lang("Groups.no_groups_yet")
@stop

@section('blankslate-text')
    @lang("Groups.no_groups_yet_text")
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id="CreateGroup" data-href="{{route('showCreateGroup', ['organiser_id' => $organiser->id])}}" href='javascript:void(0);'  class="btn btn-success mt5 btn-lg" type="button">
    <i class="ico-ticket"></i>
    @lang("Group.create_group")
</button>
@stop

