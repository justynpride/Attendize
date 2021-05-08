<section class="payment_gateway_options" id="gateway_{{$payment_gateway['id']}}">
    <h4>@lang("ManageAccount.square_settings")</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('square[appId]', trans("ManageAccount.square_app_id"), array('class'=>'control-label ')) !!}
                {!! Form::text('square[appId]', $account->getGatewayConfigVal($payment_gateway['id'], 'appId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('accessToken', trans("ManageAccount.square_access_token"), array('class'=>'control-label ')) !!}
                {!! Form::text('square[accessToken]', $account->getGatewayConfigVal($payment_gateway['id'], 'accessToken'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('locationId', trans("ManageAccount.square_location_id"), array('class'=>'control-label ')) !!}
                {!! Form::text('square[locationId]', $account->getGatewayConfigVal($payment_gateway['id'], 'locationId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>
