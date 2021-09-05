//@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang("basic.dashboard")
@stop


@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop

@section('page_title')
<i class="ico-home2"></i>
@lang("basic.users_dashboard")
@endsection

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('head')

@stop

@section('content')
<div class="tab-pane" id="users_account">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><strong>{{ trans("ManageAccount.name") }}</strong></td>
                                                <td><strong>{{ trans("ManageAccount.role") }}</strong></td>
                                                <td><strong>{{ trans("ManageAccount.email") }}</strong></td>
                                                <td><strong>{{ trans("ManageAccount.manage_events") }}</strong></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                        <tr>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
@stop