<html>
    <head>
        <title>
            @lang('Group.print_groups_title')
        </title>

        <!--Style-->
       {!!Html::style('assets/stylesheet/application.css')!!}
        <!--/Style-->

        <style type="text/css">
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                padding: 3px;
            }
            table {
                font-size: 13px;
            }
        </style>
    </head>
    <body style="background-color: #FFFFFF;" onload="window.print();">
        <div class="well" style="border:none; margin: 0;">
            {{ @trans("Group.n_attendees_for_event", ["num"=>$groups->count()]) }}
            <br>
        </div>

        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>@lang("Group.name")</th>
                    <th>@lang("Group.town")</th>
                    <th>@lang("Group.email")</th>
                    <th>@lang("Group.country_id")</th>
                    <th>@lang("Group.id")</th>
                   </tr>
            </thead>
            <tbody>
                @foreach($groups as $group)
                <tr>
                    <td>{{{$group->name}}}</td>
                    <td>{{{$group->town}}}</td>
                    <td>{{{$group->email}}}</td>
                    <td>{{{$group->country_id}}}</td>
                    <td>{{{$group->id}}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
