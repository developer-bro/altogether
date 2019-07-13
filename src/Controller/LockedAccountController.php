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
use App\Form\LockedAccountType;



class LockedAccountController extends AbstractController
{
    /**
     * @Route("/lockedaccount", methods={"GET", "POST"}, name="lockedaccount")
     *
     * 
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(LockedAccountType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $entityManager->getRepository(User::class)->findOneByEmail($form->getData()['email']);
            if ($user !== null) {
                $token = bin2hex(random_bytes(32));
                $user->setAccountUnlockToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $email = $user->getEmail();

                $message = (new \Swift_Message('Password Reset Email'))
            	->setSubject('Altogether Password Request')
            	->setFrom('donotreply@altogether.com')
            	->setTo($email)
            	->setBody(
                    $this->renderView(
                        'home/accountunlockmail.html.twig',
                        ['token' => $token]
                    ),
                    'text/html'
                );
        		$mailer->send($message);
              $this->addFlash('success', "An email has been sent to your address");
                return $this->redirectToRoute('lockconfirm');

        
        }
    }
          

        return $this->render('home/accountlockrequest.html.twig', [
            'form' => $form->createView(),
        ]);

    }



}