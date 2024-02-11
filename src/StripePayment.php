<?php 

namespace App;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

class StripePayment 
{
    /**
     * Version de l'api (important en cas de changement par défaut)
     */
    const API_VERSION = '2023-10-16';

    protected $clientSecret;

    protected $webhookSecret;

    public function __construct(string $clientSecret, string $webhookSecret = '')
    {  
        $this->clientSecret = $clientSecret;
        Stripe::setApiKey($this->clientSecret); 
        Stripe::setApiVersion(static::API_VERSION);

        $this->webhookSecret = $webhookSecret;


    }

    public function startPayment(Cart $cart)
    {
        $cartId = $cart->getId();

        $session = Session::create([

            'line_items' => [
                 [
                    'quantity' => 1, 
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => "bon pour télécharger"
                        ],
                        'unit_amount' => 2999
                    ]
                ]
                ],
                'mode' => 'payment',
                'success_url' => DOMAINE_NAME . 'success.php',
                'cancel_url' => DOMAINE_NAME . 'cancel.php',
                'billing_address_collection'  => 'required',
                'metadata' => [
                    'cart_id' => $cartId
                ]
            ]);

            header('HTTP/1.1 303 see other');
            header('location:' . $session->url);


    }

    public function handle(\PSR\Http\Message\ServerRequestInterface $request)
    {
        $signature = $request->getHeaderLine('stripe-signature');
        $body = $request->getBody();

        $event = Webhook::constructEvent(
            $body, 
            $signature,
            $this->webhookSecret
        );

        if($event->type === 'checkout.Session.completed') {
        
        }

    }


}