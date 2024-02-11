<?php

use App\Cart;
use App\StripePayment;

require_once '../vendor/autoload.php';

$cart = new Cart;

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

$payment = new StripePayment(STRIPE_SECRET_KEY, STRIPE_WEBHOOK_KEY);
$payment->handle($request);