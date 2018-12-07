<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use App\Form\PropertyType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertiesController extends AbstractController {

  /**
   * @var PropertyRepository
   */
  private $repository;

  /**
   * @var ObjectManager
   */
  private $em;

  public function __construct(PropertyRepository $repository, ObjectManager $em) {
    $this->repository = $repository;
    $this->em = $em;
  }

  /**
   * @Route("/admin/", name="admin.properties.index")
   * @return Response
   */
  public function index() {
    $properties = $this->repository->findAll();
    return $this->render('admin/properties/index.html.twig', compact('properties'));
  }

  /**
   * @Route("/admin/properties/new", name="admin.properties.new")
   * @return Response
   */
  public function new(Request $request) {
    $property = new Property();
    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($property);
      $this->em->flush();
      $this->addFlash('success', 'Bien créé avec succès');
      return $this->redirectToRoute('admin.properties.index');
    }

    return $this->render('admin/properties/new.html.twig', [
      'property' => $property,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/admin/properties/{id}/edit", name="admin.properties.edit", methods="GET|POST")
   * @return Response
   */
  public function edit(Property $property, Request $request) {
    $form = $this->createForm(PropertyType::class, $property);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->flush();
      $this->addFlash('success', 'Bien modifié avec succès');
      return $this->redirectToRoute('admin.properties.index');
    }

    return $this->render('admin/properties/edit.html.twig', [
      'property' => $property,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/admin/properties/{id}", name="admin.properties.delete", methods="DELETE")
   * @return Response
   */
  public function delete(Property $property, Request $request) {
    if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
      $this->em->remove($property);
      $this->em->flush();
      $this->addFlash('success', 'Bien supprimé avec succès');
    }
    return $this->redirectToRoute('admin.properties.index');
  }
}