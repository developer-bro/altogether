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
use App\Form\AccountEditFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class AccountInfoController extends AbstractController
{

    private $passwordEncoder;
   

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
       
    }
    /**
     * @Route("/accountinfo", methods={"GET", "POST"}, name="accountinfo")
     *
     * 
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $mail = $user->getEmail();
        $form = $this->createForm(AccountEditFormType::class, $user);
        

            

            

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $email = $form->get('email')->getData();
            
            echo "$email";
            echo "$mail";

            if($email != $mail){
                $token = bin2hex(random_bytes(32));
        $user->setEmailReqistrationToken($token);
            $user->setEnabled(FALSE);

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
          $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

return $this->redirectToRoute('confirmemail');
            }
            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('accountinfo');
        }

        return $this->render('home/accountinfo.html.twig', [
            'Form' => $form->createView(),
        ]);

    }


     /**
     * @Route("/accountinfoedit", methods={"GET", "POST"}, name="accountinfoedit")
     *
     * 
     */
    public function editindex(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $this->getUser();
        $mail = $user->getEmail();

        $password = $request->request->get('email');

        $credentials = [
            'email' => $mail,
            'password' => $password,
        ];

        
        if(!$this->passwordEncoder->isPasswordValid($user, $credentials['password'])){

            

                $message = "Invalid Credentials";

             
            
        }
        else{
            $message = "Authentication Succesful";
        }

        return new JsonResponse($message);

    

    }

   






}