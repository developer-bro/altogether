<?php

/*
 * This file is part of the Symfony package.
 *
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
use App\Entity\Upload;
use App\Form\UploadType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\FileUploader;
use App\Repository\UploadRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\HeaderUtils;



class DocumentsController extends AbstractController
{
    /**
     * @Route("/documents", methods={"GET", "POST"}, name="documents")
     *
     * 
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, FileUploader $fileUploader, UploadRepository $upladed): Response
    {
        $upload = new Upload();
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        $uploadedFiles = $upladed->findFiles($user);

        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            

            $file = $form['name']->getData();
        if ($file) {
            $fileName = $fileUploader->upload($file);
            $upload->setName($fileName);
        }
            


            $upload->setName($fileName);
            $upload->setUser($user);
            $entityManager->persist($upload);
            $entityManager->persist($user);
            $entityManager->flush();
            

            return $this->redirectToRoute('documents');
        }
        return $this->render('home/documents.html.twig', [
            'form' => $form->createView(), 'uploadedFiles' => $uploadedFiles
        ]);
    }

    /**
     * @Route("/documentdownload/{id}", methods={"GET", "POST"}, name="documentdownload")
     *
     * 
     * @IsGranted("ROLE_USER")
     */
    public function downloadindex(Request $request, FileUploader $fileUploader, UploadRepository $upladed, $id): Response
    {
       
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $file = $entityManager->getRepository(Upload::class)->findOneBy(['id' => $id, 'user' => $user]);

        $fileName = $file->getName();

        $file_with_path = $this->getParameter('directory')."/".$fileName;

        $response = new BinaryFileResponse($file_with_path);
        

        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName);


              
        
        return $response;
    
    
    }


}