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
use App\Repository\JobsRepository;
use App\Entity\User;
use App\Entity\Jobs;
use App\Repository\TaskRepository;
use App\Entity\Task;


class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", methods={"GET"}, name="dashboard")
     *
     * 
     */
    public function index(Request $request, JobsRepository $jobs, TaskRepository $tasks): Response
    {

        $user = $this->getUser();
        $latestJobs = $jobs->findLatest($user);
        $latestTasks = $tasks->findLatest1($user);
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
        $alljobscount= count($latestJobs);
        return $this->render('home/dashboard.html.twig', ['jobs' => $latestJobs, 'tasks' => $latestTasks, 'alljobscount' => $alljobscount, 'savedjobscount' => $savedjobscount, 'appliedjobscount' => $appliedjobscount, 'followupjobscount' => $followupjobscount, 'interviewjobscount' => $interviewjobscount, 'postinterviewjobscount' => $postinterviewjobscount]);
    }

}