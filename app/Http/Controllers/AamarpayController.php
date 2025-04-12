<?php
namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;

class AamarpayController extends Controller
{
public function index()
{
return view('payment.form');
}

public function makePayment(Request $request)
{
    $fields = [
        'store_id'      => env('AAMARPAY_STORE_ID'),
        'amount'        => $request->amount,
        'payment_type'  => 'VISA',
        'currency'      => 'BDT',
        'tran_id'       => uniqid(),
        'cus_name'      => $request->name,
        'cus_email'     => $request->email,
        'cus_add1'      => 'Dhaka',
        'cus_phone'     => $request->phone,
        'desc'          => 'Test Payment',
        'success_url'   => route('pay.success'),
        'fail_url'      => route('pay.fail'),
        'cancel_url'    => route('pay.cancel'),
        'signature_key' => env('AAMARPAY_SIGNATURE_KEY'),
    ];

    $url = env('AAMARPAY_SANDBOX_URL') . '/request.php';
    $response = $this->curlPost($url, $fields);

    if (strpos($response, '/paynow.php?track=') !== false) {
        // Extract just the track part
        $trackId = str_replace(['"', '\\'], '', strip_tags($response)); // Clean string
        $redirectUrl = env('AAMARPAY_SANDBOX_URL') . $trackId;
        return redirect()->away($redirectUrl);
    }

    return redirect()->back()->with('error', 'Payment gateway error. Server Response: ' . $response);
}













private function curlPost($url, $data)
{
$fields_string = http_build_query($data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For sandbox
$response = curl_exec($ch);
curl_close($ch);
return $response;
}





public function success(Request $request)
{

    \Log::info('AamarPay Success Data:', $request->all());

    return "Payment Successful! Transaction ID: " . $request->get('mer_txnid');
      }
















public function fail(Request $request)
{
return "Payment Failed!";
}

public function cancel(Request $request)
{
return "Payment Cancelled!";
}
}