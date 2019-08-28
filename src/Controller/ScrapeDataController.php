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
use App\Entity\SitesToParse;
use App\Repository\SitesToParseRepository;



class ScrapeDataController extends AbstractController
{
    /**
     * @Route("/scrapedata", methods={"GET", "POST"}, name="scrapedataindex")
     *
     * 
     */
    public function index(Request $request, SitesToParseRepository $sites): Response
    {

        $email = $request->request->get('email');

        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', $email);

if (preg_match("/linkedin/", $email))
{
    
        $title = $crawler->filter('.topcard__title')->text();
        $description = $crawler->filter('.description')->text(); 
        $company = $crawler->filter('.topcard__flavor-row span')->first()->text(); 
        
        $location = $crawler->filter('.topcard__flavor.topcard__flavor--bullet')->text();  
       
        
        $uri = $email;
}
	

if(preg_match("/indeed/", $email))
{

    $title = $crawler->filter('#vjs-jobtitle')->text();
    $description = $crawler->filter('#vjs-desc')->text(); 
    $company = $crawler->filter('#vjs-cn')->text(); 
    
    $location = $crawler->filter('#vjs-loc')->text();  
   
    
    $uri = $email;
}

if(!preg_match("/linkedin/", $email) && !preg_match("/indeed/", $email) )
{
    $values = parse_url($email);

    $host = explode('.',$values['host']);
    $website = $host[1];

    $entityManager = $this->getDoctrine()->getManager();
    $site = $entityManager->getRepository(SitesToParse::class)->findOneBy(['siteName' => $website]);
    $titleClass = $site->getTitleClass();
    
    $companyClass = $site->getCompanyClass();
    $locationClass = $site->getLocationClass();
    $descriptionClass = $site->getDescriptionClass();

    $title = $crawler->filter("{$titleClass}")->text();
    $description = $crawler->filter("{$descriptionClass}")->text(); 
    $company = $crawler->filter("{$companyClass}")->text(); 
    
    $location = $crawler->filter("{$locationClass}")->text();  
   
    
    $uri = $email;
}



        
       
        $content = ['title' => $title, 'description' => $description, 'company' => $company, 'location' => $location, 'uri' => $uri];
        

        return new JsonResponse($content);
    }


}