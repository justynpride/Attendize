<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::open(array('url' => route('postImportUsers', array('organiser_id' => $organiser->id)),'files' => true, 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-user-plus"></i>
                    @lang("User.import_users")</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
						<!-- Import -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                {!! Form::labelWithHelp('users_list', trans("User.import_file"), array('class'=>'control-label required'),
                                    trans("User.users_file_requirements")) !!}
                                {!!  Form::styledFile('users_list',1,array('id'=>'input-users_list'))  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(trans("User.import_users"), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>