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
use App\Entity\SavedJobSearches;
use App\Entity\User;
use App\Repository\SavedJobSearchesRepository;


class JobSitesToSearchController extends AbstractController
{
    /**
     * @Route("/jobsitestosearch", methods={"GET"}, name="jobsitestosearch")
     *
     * 
     */
    public function index(Request $request, SavedJobSearchesRepository $jobsearches): Response
    {
        $user = $this->getUser();
        $savedjobsearches = $jobsearches->findLatest($user);
        

        if (null == $savedjobsearches ){
            $jobName ="digital marketing";
            $location ="nyc";
            
        
        $saved = new SavedJobSearches();
        $entityManager = $this->getDoctrine()->getManager();

        $saved->setUser($user);
        $saved->setJobName($jobName);
        $saved->setLocation($location);
            $entityManager->persist($saved);
            $entityManager->persist($user);
            $entityManager->flush();

            $savedjobsearches = $jobsearches->findLatest($user);
            $savedjobsearch = $savedjobsearches[0];
            

        }
        $savedjobsearch = $savedjobsearches[0];

        
        
        return $this->render('home/jobsitestosearch.html.twig' , ['search' => $savedjobsearch]);
    }

}