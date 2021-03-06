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
use App\Entity\Task;
use App\Repository\TaskRepository;



class SavedAppliedJobsController extends AbstractController
{
    /**
     * @Route("/savedappliedjobs/{variable}",   methods={"GET", "POST"}, name="savedappliedjobs")
     *
     * 
     */
    public function index(Request $request, JobsRepository $jobs, $variable = "all"): Response
    {

        

        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(JobsSaveType::class);
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        if($variable == "saved"){

            $latestJobs = $jobs->findSaved($user);

        }

        if($variable == "applied"){

            $latestJobs = $jobs->findApplied($user);
            
        }

        if($variable == "follow up"){

            $latestJobs = $jobs->findFollowUp($user);
            
        }

        if($variable == "interview"){

            $latestJobs = $jobs->findInterview($user);
            
        }

        if($variable == "post interview follow up"){

            $latestJobs = $jobs->findPostInterview($user);
            
        }

        $savedjobs = $jobs->findSaved($user);
        $appliedjobs = $jobs->findApplied($user);
        $followupjobs = $jobs->findFollowup($user);
        $interviewjobs = $jobs->findInterview($user);
        $postinterviewjobs = $jobs->findPostInterview($user);
        $savedjobscount= count($savedjobs);
        $appliedjobscount= count($appliedjobs);
        $followupjobscount= count($followupjobs);
        $interviewjobscount= count($interviewjobs);
        $postinterviewjobscount= count($postinterviewjobs);
        $alljobs = $jobs->findLatest($user);
        $alljobscount = count($alljobs);
        

        
        

        if($variable == "all"){

        $latestJobs = $jobs->findLatest($user);

    }

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
            $jobs->SetIsSaved(TRUE);
            $jobs->setDateSaved(new \DateTime());
            $jobs->setUser($user);
            $entityManager->persist($jobs);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('savedappliedjobs');
        }
        return $this->render('home/savedappliedjobs.html.twig', [
            'form' => $form->createView(), 'jobs' => $latestJobs, 'alljobscount' => $alljobscount, 'savedjobscount' => $savedjobscount, 'appliedjobscount' => $appliedjobscount, 'followupjobscount' => $followupjobscount, 'interviewjobscount' => $interviewjobscount, 'postinterviewjobscount' => $postinterviewjobscount
        ]);
    }


     /**
     * @Route("/joblisting/{id}", methods={"GET"}, name="joblistingshow")
     *
     */
    public function jobShow($id, Request $request, JobsRepository $jobs): Response
    {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        return $this->render('home/joblisting.html.twig', ['job' => $job]);
    }

    /**
     * @Route("/savedaction/{id}", methods={"GET", "POST"}, name="savedaction")
     *
     * 
     */
    public function savedaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $job->setIsSaved(TRUE);
        $job->setIsApplied(FALSE);
        $job->setIsFollowUp(FALSE);
        $job->setIsInterview(FALSE);
        $job->setIsPostInterviewFollowUp(FALSE);

        
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }



    /**
     * @Route("/appliedaction/{id}", methods={"GET", "POST"}, name="appliedaction")
     *
     * 
     */
    public function appliedaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $job->setIsSaved(FALSE);
        $job->setIsApplied(TRUE);
        $job->setIsFollowUp(FALSE);
        $job->setIsInterview(FALSE);
        $job->setIsPostInterviewFollowUp(FALSE);

        
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }

    /**
     * @Route("/followupaction/{id}", methods={"GET", "POST"}, name="followupaction")
     *
     * 
     */
    public function followupaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $job->setIsSaved(FALSE);
        $job->setIsApplied(FALSE);
        $job->setIsFollowUp(TRUE);
        $job->setIsInterview(FALSE);
        $job->setIsPostInterviewFollowUp(FALSE);
        

      



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');
        
        
    }

    /**
     * @Route("/interviewaction/{id}", methods={"GET", "POST"}, name="interviewaction")
     *
     * 
     */
    public function interviewaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $job->setIsSaved(FALSE);
        $job->setIsApplied(FALSE);
        $job->setIsFollowUp(FALSE);
        $job->setIsInterview(TRUE);
        $job->setIsPostInterviewFollowUp(FALSE);
        

       



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }

    /**
     * @Route("/postinterviewaction/{id}", methods={"GET", "POST"}, name="postinterviewaction")
     *
     * 
     */
    public function postinterviewaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $job->setIsSaved(FALSE);
        $job->setIsApplied(FALSE);
        $job->setIsFollowUp(FALSE);
        $job->setIsInterview(FALSE);
        $job->setIsPostInterviewFollowUp(TRUE);

       




        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }

     /**
     * @Route("/deletejob/{id}", methods={"GET"}, name="deletejob")
     *
     * 
     */
    public function deletejobindex(Request $request, Jobsrepository $job, TaskRepository $task, $id): Response
    {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $jobid = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);
       
        $jobTasks = $jobid->getTasks();
        if( $jobTasks !== null )
        {
            
            foreach ( $jobTasks as $jobTask ){

                $taskid = $jobTask->getId();

                $deletetask = $task->deleteTask($user, $taskid);

                
                
            }
            $deletejob = $job->deleteJob($user, $id);
            
                return $this->redirectToRoute('savedappliedjobs');
            
        }

        $deletejob = $job->deleteJob($user, $id);
                return $this->redirectToRoute('savedappliedjobs');

           
    }

    /**
     * @Route("/saveddateaction/{id}", methods={"GET", "POST"}, name="saveddateaction")
     *
     * 
     */
    public function saveddateaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $date = $request->get('date');
    

        $job->setDateSaved(new \DateTime($date));
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }


    /**
     * @Route("/applieddateaction/{id}", methods={"GET", "POST"}, name="applieddateaction")
     *
     * 
     */
    public function applieddateaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $date = $request->get('date');
    

        $job->setDateApplied(new \DateTime($date));
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }


    /**
     * @Route("/followupdateaction/{id}", methods={"GET", "POST"}, name="followupdateaction")
     *
     * 
     */
    public function followupdateaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $date = $request->get('date');
    

        
        $job->setDateInitialFollowUp(new \DateTime($date));
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }

    /**
     * @Route("/interviewdateaction/{id}", methods={"GET", "POST"}, name="interviewdateaction")
     *
     * 
     */
    public function interviewdateaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $date = $request->get('date');
    

        $job->setDateInterview(new \DateTime($date));
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }

    /**
     * @Route("/postinterviewdateaction/{id}", methods={"GET", "POST"}, name="postinterviewdateaction")
     *
     * 
     */
    public function postinterviewdateaction(Request $request, JobsRepository $jobs, $id): Response
    {

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['id' => $id, 'User' => $user]);

        $date = $request->get('date');
    

        $job->setDateFollowUp(new \DateTime($date));
        



        
        $entityManager->persist($job);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('savedappliedjobs');


        
        
    }

   
        




}