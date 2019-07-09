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

}