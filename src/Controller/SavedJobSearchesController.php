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
Use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SavedJobSearches;
use App\Entity\User;
use App\Repository\SavedJobSearchesRepository;



class SavedJobSearchesController extends AbstractController
{
    /**
     * @Route("/savedjobsearches", methods={"GET", "POST"}, name="savedjobsearches")
     *
     * 
     */
    public function index(Request $request): Response
    {

        $email = $request->request->get('email');
        $jobName = $email[0];
        $location = $email[1];
        $user = $this->getUser();
        
        $saved = new SavedJobSearches();
        $entityManager = $this->getDoctrine()->getManager();

        $saved->setUser($user);
        $saved->setJobName($jobName);
        $saved->setLocation($location);
            $entityManager->persist($saved);
            $entityManager->persist($user);
            $entityManager->flush();

        
       
       

        $content = ["jobName" => $jobName, "location" => $location];

        

        return new JsonResponse($content);
    }


}