<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;


use App\Entity\Member;
use App\Entity\Company;

use Doctrine\ORM\EntityManagerInterface;



use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{
    /**
     * @Route("/doUpload", name="do-upload")
     * @param Request $request
     * @param string $uploadDir
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(Request $request, string $uploadDir,
    FileUploader $uploader, LoggerInterface $logger): Response
    {
      
      
        //
       // $token = $request->get("token");

    //    if (!$this->isCsrfTokenValid('upload', $token))
    //    {
          //  $logger->info("CSRF failure");

         //   return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
           //     ['content-type' => 'text/plain']);
      //  }

        $file = $request->files->get('photo');

        if (empty($file))
        {
            return new Response("No file specified",
               Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $filename = $file->getClientOriginalName();
        $uploader->upload($uploadDir, $file, $whn.".png");
        

        $entityManager = $this->getDoctrine()->getManager();
        $whn = date("Ymd his");
        
        $product = new Member();

        $product->setEmail($request->get('companyEmail'));
      
        $product->setPassword($request->get('password'));

        $entityManager->persist($product);

      
        $entityManager->flush();



        
        $company = new Company();

        $company->setCompanyLogo($whn.".png");
        $company->setEmail($request->get('companyEmail'));
        $company->setCompanyName($request->get('companyName'));
       
        $entityManager->persist($company);

      
        $entityManager->flush();





        return new Response("File uploaded",  Response::HTTP_OK,
            ['content-type' => 'text/plain']);
    }


    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @param string $uploadDir
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @return Response
     */


    public function addCompany(Request $request, string $uploadDir,
    FileUploader $uploader, LoggerInterface $logger): Response
    {
      

        $file = $request->files->get('photo');

        if (empty($file))
        {
            return new Response("No file specified",
               Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        
        $whn = date("Ymd his");
        $filename = $file->getClientOriginalName();
        $uploader->upload($uploadDir, $file, $whn.".png");
        

        $entityManager = $this->getDoctrine()->getManager();


        $company = new Company();

        $company->setCompanyLogo($whn.".png");
        $company->setEmail($request->get('companyEmail'));
        $company->setCompanyName($request->get('companyName'));
       
        $entityManager->persist($company);

      
        $entityManager->flush();





        return new Response("File uploaded",  Response::HTTP_OK,
            ['content-type' => 'text/plain']);
    }



    /**
     * @Route("/login", name="login")
     * @param Request $request
     */
    public function login(Request $request): Response
    {
        $member = $this->getDoctrine()
            ->getRepository(Member::class)
            ->findOneBy([
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ]);
            
        
            $result = "";

        if (!$member) {
            $result = "User not found";
         
        }

        else{
            $result = "User found";

        }


        return new Response($result,  Response::HTTP_OK,
        ['content-type' => 'text/plain']);

    }



     /**
     * @Route("/companies", name="companies")
     * @param Request $request
     */
    public function getCompanies(Request $request): Response
    {
        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findBy([
                'email' => $request->get('email')
              
            ]);
            
        
   
        // if you know the data to send when creating the response
        $response = new JsonResponse(['data' => $companies]);
        return $response;
        // if you don't know the data to send when creating the response
        //$response = new JsonResponse();
        // ...
        //$response->setData(['data' => 123]);

        // if the data to send is already encoded in JSON
        //$response = JsonResponse::fromJsonString('{ "data": 123 }');


    }

    
    /**
     * @Route("/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($company);
        $entityManager->flush();

        return new Response("deleted",  Response::HTTP_OK,
        ['content-type' => 'text/plain']);
    }


    /**
     * @Route("/edit")
     */
    public function edit(Request $request, string $uploadDir,
    FileUploader $uploader, LoggerInterface $logger): Response
    {
      

        $file = $request->files->get('photo');

        if (empty($file))
        {
            return new Response("No file specified",
               Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }


        $entityManager = $this->getDoctrine()->getManager();
        $company = $entityManager->getRepository(Company::class)->find($request->get('id'));

        if (!$company) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }


        $whn = date("Ymd his");
        $filename = $file->getClientOriginalName();
        $uploader->upload($uploadDir, $file, $whn.".png");
        

        $entityManager = $this->getDoctrine()->getManager();


        $company = new Company();

        $company->setCompanyLogo($whn.".png");
        $company->setEmail($request->get('companyEmail'));
        $company->setCompanyName($request->get('companyName'));
       
        $entityManager->flush();

        return new Response("updated",  Response::HTTP_OK,
        ['content-type' => 'text/plain']);
    }


}