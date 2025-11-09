<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\ShippingAddress;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;



class StripeWebhookController extends Controller
{
    public function handle (Request $request) {
        //Stripeの秘密鍵
        Stripe::setApiKey(config('services.stripe.secret'));
        //webhookシークレットキー
        $endpoint_secret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }
        //イベントタイプを確認
        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            // Stripeセッション作成時に設定したmetadataから情報を取得
            $itemId = $paymentIntent->metadata->item_id ?? null;
            $userId = $paymentIntent->metadata->user_id ?? null;
            if ($itemId && $userId) {
                //購入情報を保存
                Purchase::firstOrCreate([
                    'user_id' => $userId,
                    'item_id' => $itemId,
                ], [
                    'shipping_address_id' => null,
                    'payment_method' => $paymentIntent->payment_method_types[0] === 'konbini' ? 1 : 2,
                ]);
            }
        }
        return response('Webhook received', 200);
    }
}
