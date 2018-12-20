<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminPropertyController extends  AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;


    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name = "admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response;
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));

    }

    /**
     * @Route("/admin/property/create", name= "admin.property.new")
     */
    public function new( Request $request,EntityManagerInterface $entityManager)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash('success', 'Votre Bien est correctement enregistré ');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/new.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);

    }



    /**
     * @Route("/admin/property/{id}", name = "admin.property.edit", methods={"GET|POST"})
     * @param Property $property
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            $this->addFlash('success', 'Votre formulaire est correctement modifié ');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/edit.html.twig", [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods={"DELETE"})
     * @param Property $property
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property,Request $request, EntityManagerInterface $entityManager)
    {
        if( $this->isCsrfTokenValid($property->getId(), $request->get('_token')))
        {
            $entityManager->remove($property);
            $entityManager->flush();
            $this->addFlash('delete', 'Votre Bien est supprimé ');

        }


        return $this->redirectToRoute('admin.property.index');

    }













}