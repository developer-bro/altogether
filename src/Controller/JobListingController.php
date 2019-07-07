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


class JobListingController extends AbstractController
{
    /**
     * @Route("/joblisting", methods={"GET"}, name="joblisting")
     *
     * 
     */
    public function index(Request $request, JobsRepository $jobs): Response
    {

        $user = $this->getUser();
        $latestJobs = $jobs->findLatest($user);
        $latestjob = $latestJobs[0];
        return $this->render('home/joblisting.html.twig', ['job' => $latestjob]);
    }

}