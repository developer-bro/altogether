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
use App\Form\NewPasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class NewPasswordController extends AbstractController
{
    /**
     * @Route("/newpassword/{token}", methods={"GET", "POST"}, name="newpassword")
     *
     * 
     */
    public function index(Request $request, string $token, UserPasswordEncoderInterface $encoder): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(['passwordRequestToken' => $token]);


        if (!$token || !$user instanceof User) {
            $this->addFlash('danger', "User not found");
            return $this->redirectToRoute('passwordrequest');
        }
                $form = $this->createForm(NewPasswordType::class, $user);

                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $plainPassword = $form->getData()->getPassword();
                    $encoded = $encoder->encodePassword($user, $plainPassword);
                    $user->setPassword($encoded);
                    $user->setPasswordRequestToken(null);
                    $entityManager->persist($user);
                    $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('passwordsuccess');
        }

    

        return $this->render('home/newpassword.html.twig', [
            'form' => $form->createView(),
        ]);

    



}

}