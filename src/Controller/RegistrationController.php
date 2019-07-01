<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $token = bin2hex(random_bytes(32));
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setEmailReqistrationToken($token);
            $user->setEnabled(FALSE);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();




            $email = $form->get('email')->getData();

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

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
