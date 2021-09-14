<div role="dialog"  class="modal fade" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-edit"></i> Edit {{$user->first_name}} {{$user->last_name}}
                    </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
{{$user->first_name}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
{{$user->last_name}}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
{{$user->email}}
{{$user->role}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">

            </div>
        </div><!-- /end modal content-->

    </div>
</div>
