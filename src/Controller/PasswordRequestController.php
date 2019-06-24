<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\PasswordRequestType;



class PasswordRequestController extends AbstractController
{
    /**
     * @Route("/passwordrequest", methods={"GET", "POST"}, name="passwordrequest")
     *
     * 
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(PasswordRequestType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $entityManager->getRepository(User::class)->findOneByEmail($form->getData()['email']);
            if ($user !== null) {
                $token = bin2hex(random_bytes(32));
                $user->setPasswordRequestToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $email = $user->getEmail();

                $message = (new \Swift_Message('Password Reset Email'))
            	->setSubject('Altogether Password Request')
            	->setFrom('donotreply@altogether.com')
            	->setTo($email)
            	->setBody(
                    $this->renderView(
                        'home/passwordmail.html.twig',
                        ['token' => $token]
                    ),
                    'text/html'
                );
        		$mailer->send($message);
              $this->addFlash('success', "An email has been sent to your address");
                return $this->redirectToRoute('app_register');

        
        }
    }
          

        return $this->render('home/passwordrequest.html.twig', [
            'form' => $form->createView(),
        ]);

    }



}