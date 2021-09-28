<html>
    <head>
        <title>
            @lang('User.print_users_title')
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
            {{ @trans("User.n_users_for_event", ["num"=>$users->count()]) }}
            <br>
        </div>

        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>@lang("User.first_name")</th>
                    <th>@lang("User.last_name")</th>
                    <th>@lang("User.email")</th>
                    <th>@lang("User.id")</th>
                   </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{{$user->first_name}}}</td>
                    <td>{{{$user->last_name}}}</td>
                    <td>{{{$user->email}}}</td>
                    <td>{{{$user->id}}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>