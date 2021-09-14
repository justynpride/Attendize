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

    </div>
</div>
<div class="col-md-3">
   
    <div class="input-group">

    </div>

</div>
@stop


@section('content')

<!--Start Groups table-->
<div class="row">
  <div class="col-md-12">

        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>
                            
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                         
                        <tr>
                            <td>
                            
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td class="text-center">
     
                            </td>
                        </tr>
                        
                    
                   </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="col-md-12">
        
    </div> 

</div>    <!--/End Groups table-->

@stop
