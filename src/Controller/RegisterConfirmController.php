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



class RegisterConfirmController extends AbstractController
{
    /**
     * @Route("/registerconfirm/{token}", methods={"GET", "POST"}, name="registrationconfirm")
     *
     * 
     */
    public function index(Request $request, string $token): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(['emailReqistrationToken' => $token]);


        if (!$token || !$user instanceof User) {
            $this->addFlash('danger', "User not found");
            return $this->redirectToRoute('app_register');
        }
                    $email = $user->getEmail();
                    

                    $user->setEmailReqistrationToken(null);
                    $user->setEnabled(TRUE);
                    $entityManager->persist($user);
                    $entityManager->flush();
        

    

        return $this->render('home/registrationconfirm.html.twig', [
            'email' => $email,
        ]);

    



}

}