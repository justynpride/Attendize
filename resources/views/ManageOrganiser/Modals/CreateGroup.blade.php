<div role="dialog"  class="modal fade" style="display: none;">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">
                        <i class="ico-edit"></i> @lang("Group.create_group")
                        </h3>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', trans("Group.name"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('name', value($group->name),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('town', trans("Group.town"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('town', value($group->name),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('email', trans("Group.email"), array('class'=>'control-label required')) !!}
                                {!!  Form::text('email', value($group->email),
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