<?php
namespace Services\PaymentGateway;

class Square
{

    CONST GATEWAY_NAME = 'Square';

    private $transaction_data;

    private $gateway;

    private $extra_params = ['card_nonce'];

    public function __construct($gateway, $options = [])
    {
        $this->gateway = $gateway;
        $this->options = $options;
        if(array_key_exists('testMode', $options) && $options['testMode']) {
            $this->gateway->setTestMode(true);
        }
    }

    private function createTransactionData($order_total, $order_email, $event)
    {
        $returnUrl = route('showEventCheckoutPaymentReturn', [
            'event_id' => $event->id,
            'is_payment_successful' => 1,
        ]);

        $this->transaction_data = [
            'amount' => $order_total,
            'currency' => $event->currency->code,
            'nonce' => $this->options["card_nonce"],
            'note' => $this->options["note"],
            'idempotency_key' => uniqid()
        ];

        return $this->transaction_data;
    }

    public function startTransaction($order_total, $order_email, $event)
    {
        $this->createTransactionData($order_total, $order_email, $event);
        $response = $this->gateway->purchase($this->transaction_data)->send();

        return $response;
    }

    public function getTransactionData()
    {
        return $this->transaction_data;
    }

    public function extractRequestParameters($request)
    {
        foreach ($this->extra_params as $param) {
            if (!empty($request->get($param))) {
                $this->options[$param] = $request->get($param);
            }
        }
    }

    public function extractOrderParameters($order)
    {

        $items = [];

        foreach($order["tickets"] as $ticket) {
            $item = [];
            $item["name"] = $ticket["ticket"]["title"];
            $item["price"] = $ticket["full_price"];
            $item["quantity"] = $ticket["qty"];

            $items[] = $ticket["ticket"]["title"] . ": " . $ticket["qty"] . " X $" . $ticket["full_price"];
        }

        $this->options["note"] = implode("\n", $items);
    }

    public function completeTransaction($data)
    {
    }

    public function getAdditionalData($response)
    {
       return [];
    }

    public function storeAdditionalData()
    {
        return true;
    }

    public function refundTransaction($order, $refund_amount, $refund_application_fee)
    {

        $request = $this->gateway->refund([
            'transactionId' => $order->transaction_id,
            'amount' => $refund_amount,
            'currency' => $order->event->currency->code,
            'refundApplicationFee' => $refund_application_fee
        ]);

        $response = $request->send();

        if ($response->isSuccessful()) {
            $refundResponse['successful'] = true;
        } else {
            $refundResponse['successful'] = false;
            $refundResponse['error_message'] = $response->getMessage();
        }

        return $refundResponse;
    }

}