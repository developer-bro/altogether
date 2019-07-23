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
use App\Entity\CVupload;
use App\Repository\CVuploadRepository;
use App\Form\CVuploadType;



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
     * @Route("/coverletter", methods={"GET", "POST"}, name="coverletter")
     *
     * 
     * @IsGranted("ROLE_USER")
     */
    public function coverindex(Request $request, FileUploader $fileUploader, CVuploadRepository $cvupladed): Response
    {
        


        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

    
        

        

        $cvupload = new CVupload();
        $cvuploadedFiles = $cvupladed->findFiles($user);

        $cvform = $this->createForm(CVuploadType::class, $cvupload);
        $cvform->handleRequest($request);
        if ($cvform->isSubmitted() && $cvform->isValid()) {
            
            

            $newfile = $cvform['name']->getData();
        if ($newfile) {
            $filename = $fileUploader->upload($newfile);
            $cvupload->setName($filename);
        }
            


            $cvupload->setName($filename);
            $cvupload->setUser($user);
            $entityManager->persist($cvupload);
            $entityManager->persist($user);
            $entityManager->flush();
            

            return $this->redirectToRoute('coverletter');
        }


        return $this->render('home/coverletter.html.twig', [
            'cvform' => $cvform->createView(), 'cvuploadedFiles' => $cvuploadedFiles
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

    /**
     * @Route("/deletefile/{id}", methods={"GET"}, name="deletefile")
     *
     * 
     */
    public function deleteindex(Request $request, UploadRepository $upladed, $id): Response
    {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
       

        $file = $entityManager->getRepository(Upload::class)->findOneBy(['id' => $id, 'user' => $user]);

        $fileName = $file->getName();

        

        $file_with_path = $this->getParameter('directory')."/".$fileName;

        
if (!unlink($file_with_path))
  {
  echo ("Error deleting $file_with_path");
  }
else
  {
  echo ("Deleted $file_with_path");
  }

  $deletefile = $upladed->deleteFile($user, $id);
                return $this->redirectToRoute('documents');
    }

     /**
     * @Route("/updatefile/{id}", methods={"GET", "POST"}, name="updatefile")
     *
     * 
     */
    public function updateindex(Request $request, UploadRepository $upladed, $id): Response
    {
        $user = $this->getUser();
        $input = $request->request->get('filename');

        echo "$input";
       
        $inputname = $this->getParameter('directory')."/".$input;
       
       
        

        $entityManager = $this->getDoctrine()->getManager();

        $file = $entityManager->getRepository(Upload::class)->findOneBy(['id' => $id, 'user' => $user]);

        $fileName = $file->getName();

        

        $file_with_path = $this->getParameter('directory')."/".$fileName;

        rename($file_with_path, $inputname);

        $updatesearch = $upladed->updateFile($user, $id, $input);

        return $this->redirectToRoute('documents');
                
    }

    /**
     * @Route("/cvdocumentdownload/{id}", methods={"GET", "POST"}, name="cvdocumentdownload")
     *
     * 
     * @IsGranted("ROLE_USER")
     */
    public function cvdownloadindex(Request $request, FileUploader $fileUploader, CVuploadRepository $upladed, $id): Response
    {
       
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $file = $entityManager->getRepository(CVupload::class)->findOneBy(['id' => $id, 'user' => $user]);

        $fileName = $file->getName();

        $file_with_path = $this->getParameter('directory')."/".$fileName;

        $response = new BinaryFileResponse($file_with_path);
        

        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName);


              
        
        return $response;
    
    
    }

    /**
     * @Route("/cvdeletefile/{id}", methods={"GET"}, name="cvdeletefile")
     *
     * 
     */
    public function cvdeleteindex(Request $request, CVuploadRepository $upladed, $id): Response
    {
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
       

        $file = $entityManager->getRepository(CVupload::class)->findOneBy(['id' => $id, 'user' => $user]);

        $fileName = $file->getName();

        

        $file_with_path = $this->getParameter('directory')."/".$fileName;

        
if (!unlink($file_with_path))
  {
  echo ("Error deleting $file_with_path");
  }
else
  {
  echo ("Deleted $file_with_path");
  }

  $deletefile = $upladed->deleteFile($user, $id);
                return $this->redirectToRoute('documents');
    }

     /**
     * @Route("/cvupdatefile/{id}", methods={"GET", "POST"}, name="cvupdatefile")
     *
     * 
     */
    public function cvupdateindex(Request $request, CVuploadRepository $upladed, $id): Response
    {
        $user = $this->getUser();
        $input = $request->request->get('filename');

        echo "$input";
       
        $inputname = $this->getParameter('directory')."/".$input;
       
       
        

        $entityManager = $this->getDoctrine()->getManager();

        $file = $entityManager->getRepository(CVupload::class)->findOneBy(['id' => $id, 'user' => $user]);

        $fileName = $file->getName();

        

        $file_with_path = $this->getParameter('directory')."/".$fileName;

        rename($file_with_path, $inputname);

        $updatesearch = $upladed->updateFile($user, $id, $input);

        return $this->redirectToRoute('documents');
                
    }


    


}