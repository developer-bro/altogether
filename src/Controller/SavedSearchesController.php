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
Use Symfony\Component\HttpFoundation\JsonResponse;


class SavedSearchesController extends AbstractController
{
    /**
     * @Route("/savedsearches", methods={"GET"}, name="savedsearches")
     *
     * 
     */
    public function index(Request $request, SavedJobSearchesRepository $jobsearches): Response
    {
        $user = $this->getUser();
        $savedjobsearches = $jobsearches->findLatest($user);
        return $this->render('home/savedsearches.html.twig', [
            'searches' => $savedjobsearches,
        ]);
    }


     /**
     * @Route("/jobsitestosearch/{id}", methods={"GET"}, name="searchshow")
     *
     */
    public function searchShow($id, Request $request, SavedJobSearchesRepository $jobsearches): Response
    {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $search = $entityManager->getRepository(SavedJobSearches::class)->findOneBy(['id' => $id, 'user' => $user]);

        return $this->render('home/jobsitestosearch.html.twig', ['search' => $search]);
    }

    /**
     * @Route("/deletesearch/{id}", methods={"GET"}, name="deletesearch")
     *
     * 
     */
    public function deleteindex(Request $request, SavedJobSearchesRepository $jobsearches, $id): Response
    {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $deletesearch = $jobsearches->deleteSearch($user, $id);
                return $this->redirectToRoute('savedsearches');
    }

        /**
     * @Route("/updatesearch/{id}", methods={"GET", "POST"}, name="updatesearch")
     *
     * 
     */
    public function updateindex(Request $request, SavedJobSearchesRepository $jobsearches, $id): Response
    {
        $user = $this->getUser();
        $input = $request->request->get('searchname');
        $arr = explode(',', $input, 2);

        $first = reset($arr);
        $last = end($arr);

        echo "$first";
        echo "$last";
       
       
        

        $entityManager = $this->getDoctrine()->getManager();
        $updatesearch = $jobsearches->updateSearch($user, $id, $first, $last);

        return $this->redirectToRoute('savedsearches');
                
    }

}