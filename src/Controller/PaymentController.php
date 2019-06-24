<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
use App\Entity\Payment;

class PaymentController extends AbstractController 
{
    /**
     * @Route("/prepare-payment", name="payum_prepare_payment")
     */
    public function prepare(Payum $payum) 
    {
        $gatewayName = 'offline';
        
        $storage = $payum->getStorage(Payment::class);
        
        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount(123); // 1.23 EUR
        $payment->setDescription('A description');
        $payment->setClientId('anId');
        $payment->setClientEmail('foo@example.com');
        
        $storage->update($payment);
        
        $captureToken = $payum->getTokenFactory()->createCaptureToken(
            $gatewayName, 
            $payment, 
            'payum_payment_done' // the route to redirect after capture
        );
        
        return $this->redirect($captureToken->getTargetUrl());    
    }

    /**
     * @Route("/payment-done", name="payum_payment_done")
     */
    public function done(Request $request, Payum $payum)
    {
        $token = $payum->getHttpRequestVerifier()->verify($request);
        
        $gateway = $payum->getGateway($token->getGatewayName());
        
        // You can invalidate the token, so that the URL cannot be requested any more:
        // $payum->getHttpRequestVerifier()->invalidate($token);
        
        // Once you have the token, you can get the payment entity from the storage directly. 
        // $identity = $token->getDetails();
        // $payment = $payum->getStorage($identity->getClass())->find($identity);
        
        // Or Payum can fetch the entity for you while executing a request (preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();
        
        // Now you have order and payment status
        
        return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));
    }

}