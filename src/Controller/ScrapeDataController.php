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


class ScrapeDataController extends AbstractController
{
    /**
     * @Route("/scrapedata", methods={"GET", "POST"}, name="scrapedataindex")
     *
     * 
     */
    public function index(Request $request): Response
    {

        $email = $request->request->get('email');

        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', $email);
        $client->waitFor('.topcard__flavor-row', 5000); 
        $title = $crawler->filter('.topcard__title')->text();
        $description = $crawler->filter('.description')->text(); 
        $company = $crawler->filter('.topcard__flavor-row span')->first()->text(); 
        
        $location = $crawler->filter('.topcard__flavor.topcard__flavor--bullet')->text();  
        $link = $crawler->selectLink('Apply')->link();  
        $uri = $link->getUri();
       

        $content = ['title' => $title, 'description' => $description, 'company' => $company, 'location' => $location, 'uri' => $uri];

        

        return new JsonResponse($content);
    }


}