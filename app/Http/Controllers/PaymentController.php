<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration from environment variables
        Config::$serverKey = env("MIDTRANS_SERVER_KEY");
        Config::$clientKey = env("MIDTRANS_CLIENT_KEY");
        Config::$isProduction = env("MIDTRANS_IS_PRODUCTION", false);
        Config::$isSanitized = env("MIDTRANS_IS_SANITIZED", true);
        Config::$is3ds = env("MIDTRANS_IS_3DS", true);
    }

    public function createTransaction(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);
        
        // Prepare transaction data
        $transactionDetails = [
            'order_id' => uniqid(), // Unique order ID
            'gross_amount' => $request->amount, // Amount from the form
        ];
        
        $customerDetails = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        
        // Create the transaction data
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];
        
        // Use Snap to create a transaction and get snapToken
        try {
            $snap = new Snap();
            $response = $snap->createTransaction($transactionData);

            // Access the token properly using object notation
            return response()->json(['snapToken' => $response->token]);
        } catch (\Exception $e) {
            Log::error('Midtrans Transaction Error: ' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'Transaction failed. Please try again later.'], 500);
        }
    }
    
    public function notificationHandler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        // Log the notification for debugging
        Log::info('Midtrans Notification: ', (array) $notification);
        
        // Validate the notification before processing
        if (!isset($notification->transaction_status)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid notification'], 400);
        }
        
        // Check the transaction status
        switch ($notification->transaction_status) {
            case 'capture':
                if ($notification->payment_type == 'credit_card') {
                    if ($notification->fraud_status == 'challenge') {
                        // Handle challenge (e.g. notify user, etc.)
                    } else {
                        // Payment successfully captured, update order status
                        // Example: Order::where('id', $notification->order_id)->update(['status' => 'paid']);
                    }
                }
                break;
            case 'settlement':
                // Payment settled, update order status
                // Example: Order::where('id', $notification->order_id)->update(['status' => 'paid']);
                break;
            case 'pending':
                // Handle pending payment
                // Example: Order::where('id', $notification->order_id)->update(['status' => 'pending']);
                break;
            case 'deny':
                // Payment denied, update order status
                // Example: Order::where('id', $notification->order_id)->update(['status' => 'denied']);
                break;
            case 'expire':
                // Payment expired, update order status
                // Example: Order::where('id', $notification->order_id)->update(['status' => 'expired']);
                break;
            case 'cancel':
                // Payment canceled, update order status
                // Example: Order::where('id', $notification->order_id)->update(['status' => 'canceled']);
                break;
        }
    
        return response()->json(['status' => 'success']);
    }
}
