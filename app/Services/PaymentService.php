<?php
declare(strict_types=1);

namespace App\Services;
use YooKassa\Client;

class PaymentService
{

    private  function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'),config('services.yookassa.secret_key'));
        return $client;
    }

    public function createPayment(float $amount, string $desc, array $options =[])
    {
        $client = $this->getClient();
        $payment= $client->createPayment(   //это метод классса YooKassa\Client;
           ['amount'=>[
               'value'=>$amount,
               'currency'=>'RUB'
           ],
               'capture'=>false,
               'confirmation'=>[
                   'type'=>'redirect',
                   'return_url'=>route('payment.callback')
               ],
               'metadata'=>[
                   'transaction_id'=>$options['transaction_id'],
               ],
               'descriptilon'=>$desc
           ],
        uniqid('',true));

   return $payment->getConfirmation()->getConfirmationUrl();
    }
}
