<?php 

require_once 'vendor/autoload.php';
require_once 'config/define.php';

$cart = new App\Cart();

$payment = new App\StripePayment(STRIPE_SECRET_KEY);

$payment->startPayment(
    $cart
);
