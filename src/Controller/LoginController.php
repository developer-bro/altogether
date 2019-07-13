<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;



class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        
        
        
        if (null != $error ){
            $errormsg = $error->getMessageKey();
            if($errormsg == "Invalid credentials."){

                $entityManager = $this->getDoctrine()->getManager();
                $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $lastUsername]);

                $attempts = $user->getNoOfAttempts();
                if($attempts == 4)
                {
                    $user->setIsAccountNonLocked(FALSE);
                    $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('lockedaccount');
                }
                $user->setNoOfAttempts($attempts + 1);
                $entityManager->persist($user);
                $entityManager->flush();

                        
            }

                
            
            }
            
        

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
