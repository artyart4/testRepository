<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class PaymentController extends Controller
{
    public function index()
    {
         return view('payment.index');
    }

    public function callback(Request $request, PaymentService $service)
    {
      $source = file_get_contents('php://input');
      $requestBody = json_decode($source, true);
      $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED) ? new NotificationSucceeded($requestBody) : new NotificationWaitingForCapture($requestBody);
      $payment = $notification->getObject();
      if (isset($payment->status) && $payment->status === 'succeeded'){
          if ((bool)$payment->paid === true){
            $metadata = (object) $payment->metadata;
            $transactionId = $metadata->transaction_id;
            $transaction = Transaction::query()->find($transactionId);
            $transaction->status = PaymentStatusEnum::CONFIRMED;
            $transaction->save();
            if (Cache::has('amount')){
              \cache()->forever('balance',(float)cache()->get('balance') + $payment->amount->value);
            }else{
            \cache()->forever('balance', (float)$payment->amount->value);
            }
          }

      }
    }

    public function create(Request $request,PaymentService $service)
    {
       $amount = (float)$request->input('amount');
       $desc = $request->input('description');

       $transaction = Transaction::create([
          'amount'=>$amount,
          'description'=>$desc
       ]);

       if ($transaction)
       {
          $link =  $service->createPayment($amount, $desc,['transaction_id'=>$transaction->id]);
          return redirect()->away($link);
       }


    }
}
