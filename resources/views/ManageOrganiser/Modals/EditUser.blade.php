<div role="dialog"  class="modal fade" style="display: none;">
        {!! Form::model($user, array('url' => route('postEditUser', array('$user->id')), 'class' => 'ajax closeModalAfter')) !!}
        <div class="modal-dialog account_settings">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">
                        <i class="ico-user"></i>
                        Edit {{$user->first_name}} {{$user->last_name}}
                        </h3>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('first_name', trans("User.first_name"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('first_name', value($user->first_name),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('last_name', trans("User.last_name"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('last_name', value($user->last_name),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('email', trans("User.email"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('email', value($user->email),
                                            array(
                                            'class'=>'form-control '
                                            ))  !!}
                            </div>
                        </div>
                    </div>

 
                </div>
                <div class="modal-footer">
                   {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                   {!! Form::submit(trans("basic.save_details"), ['class' => 'btn btn-success pull-right']) !!}
                </div>
            </div>
        </div>

</div>
