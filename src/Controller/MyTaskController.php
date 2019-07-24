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
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Form\TaskType;
use App\Repository\JobsRepository;
use App\Entity\Jobs;
Use Symfony\Component\HttpFoundation\JsonResponse;


class MyTaskController extends AbstractController
{
    /**
     * @Route("/mytask", methods={"GET", "POST"}, name="mytask")
     *
     * 
     */
    public function index(Request $request, TaskRepository $task, JobsRepository $jobs): Response
    {

        
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        

        $tasks = $task->findLatest1($user);
       
        
        $latestJobs = $jobs->findLatest($user);

 

        $savedjobs = $jobs->findSaved($user);
        $savedjobscount= count($savedjobs);


        $appliedjobs = $jobs->findApplied($user);
        $followupjobs = $jobs->findFollowup($user);
        $interviewjobs = $jobs->findInterview($user);
        $postinterviewjobs = $jobs->findPostInterview($user);
        $appliedjobscount= count($appliedjobs);
        $followupjobscount= count($followupjobs);
        $interviewjobscount= count($interviewjobs);
        $postinterviewjobscount= count($postinterviewjobs);
        $alljobscount= count($latestJobs);

        
        $form = $this->createForm(TaskType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        

        $name = $form->get('name')->getData();
        $fromName = $form->get('fromName')->getData();
        $toName = $form->get('toName')->getData();
        $dueDate = $form->get('dueDate')->getData();
        $notes = $form->get('notes')->getData();
        $job = $entityManager->getRepository(Jobs::class)->findOneBy(['comapnyName' => $toName, 'User' => $user]);

        $task = new Task();
        $task->setName($name);
        $task->setFromName($fromName);
        $task->setToName($toName);
        $task->setDueDate($dueDate);
        $task->setNotes($notes);
        $task->setTaskStatus("Mark as Complete");
        $task->setIsComplete(FALSE);
        $task->setUser($user);
        $task->setJob($job);

        $entityManager->persist($task);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('mytask');
    }

        return $this->render('home/mytask.html.twig', [
            'form' => $form->createView(), 'tasks' => $tasks, 'jobs' => $latestJobs, 'alljobscount' => $alljobscount, 'savedjobscount' => $savedjobscount, 'appliedjobscount' => $appliedjobscount, 'followupjobscount' => $followupjobscount, 'interviewjobscount' => $interviewjobscount, 'postinterviewjobscount' => $postinterviewjobscount]);
    }

    /**
     * @Route("/completetask/{id}", methods={"GET", "POST"}, name="completetask")
     *
     * 
     */
    public function completeindex(Request $request, TaskRepository $task, JobsRepository $jobs, $id): Response
    {

        
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $completetask = $entityManager->getRepository(Task::class)->findOneBy(['id' => $id, 'user' => $user]);
        $completetask->setIsComplete(TRUE);
        $completetask->setTaskStatus("Completed");
        $completetask->setDateThankYouLetter(new \DateTime());

        
        
        $entityManager->persist($completetask);
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('mytask');
    }



}