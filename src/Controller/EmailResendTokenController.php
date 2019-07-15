<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\EmailResendType;

class EmailResendTokenController extends AbstractController
{
    /**
     * @Route("/emailresendtoken", name="emailresendtoken")
     */
    public function register(Request $request, \Swift_Mailer $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
                
        
        $form = $this->createForm(EmailResendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            

            




            $email = $form->get('email')->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            $token = $user->getEmailReqistrationToken();

            $message = (new \Swift_Message('Registration Confirm Request'))
            ->setSubject('Altogether Registration Request')
            ->setFrom('donotreply@altogether.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'home/registrationmail.html.twig',
                    ['token' => $token]
                ),
                'text/html'
            );
            $mailer->send($message);
          $this->addFlash('success', "An email has been sent to your address");


            // do anything else you need here, like send an email

            return $this->redirectToRoute('confirmemail');
        }

        return $this->render('home/emailresend.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
