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
use App\Entity\Jobs;
use App\Form\JobsSaveType;
use App\Entity\User;
use App\Repository\JobsRepository;



class SavedAppliedJobsController extends AbstractController
{
    /**
     * @Route("/savedappliedjobs", methods={"GET", "POST"}, name="savedappliedjobs")
     *
     * 
     */
    public function index(Request $request, JobsRepository $jobs): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(JobsSaveType::class);
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $latestJobs = $jobs->findLatest($user);
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $jobs = new Jobs();
            $title = $form->get('title')->getData();
            $location = $form->get('location')->getData();
            $comapnyName = $form->get('comapnyName')->getData();
            $description = $form->get('description')->getData();
            $uri = $form->get('uri')->getData();
            $jobs->setTitle($title);
            $jobs->setLocation($location);
            $jobs->setComapnyName($comapnyName);
            $jobs->setDescription($description);
            $jobs->setUri($uri);
            $jobs->setDateSaved(new \DateTime());
            $jobs->setUser($user);
            $entityManager->persist($jobs);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }
        return $this->render('home/savedappliedjobs.html.twig', [
            'form' => $form->createView(), 'jobs' => $latestJobs,
        ]);
    }

    /**
     * @Route("/savedappliedaction", methods={"GET", "POST"}, name="savedappliedaction")
     *
     * 
     */
    public function savedindex(Request $request): Response
    {

        
        return $this->render('home/savedappliedjobs.html.twig');
    }


}