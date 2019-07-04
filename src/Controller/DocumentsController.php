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



class DocumentsController extends AbstractController
{
    /**
     * @Route("/documents", methods={"GET", "POST"}, name="documents")
     *
     * 
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request): Response
    {
        $upload = new Upload();
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Upload::class);
        $uploadedFiles = $repository->findAll();

        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $file = $upload->getName();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            
            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
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
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


}