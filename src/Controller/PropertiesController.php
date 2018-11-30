<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertiesController extends AbstractController {
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
   * @Route("/biens", name="properties.index")
   * @return Response
   **/
  public function index(): Response {
    $property = $this->repository->findAllVisible();
    return $this->render('properties/index.html.twig', [
      'current_menu' => 'properties'
    ]);
  }

  /**
   * @Route("/biens/{slug}-{id}", name="properties.show", requirements={"slug": "[a-z0-9\-]*"})
   * @return Response
   **/
  public function show(Property $property, string $slug): Response {
    if ($property->getSlug() !== $slug) {
      return $this->redirectToRoute('properties.show', [
        'id' => $property->getId(),
        'slug' => $property->getSlug()
      ], 301);
    }
    
    return $this->render('properties/show.html.twig', [
      'property' => $property,
      'current_menu' => 'properties'
    ]);
  }
}