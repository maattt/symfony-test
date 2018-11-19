<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertiesController extends AbstractController {
  /**
   * @var PropertyRepository
   */
  private $repository;

  public function __construct(PropertyRepository $repository) {
    $this->repository = $repository;
  }

  /**
   * @Route("/biens", name="properties.index")
   * @return Response
   **/
  public function index(): Response {
    // $property = new Property();
    // $property->setTitle('Premier bien')
    //          ->setPrice(200000)
    //          ->setRooms(4)
    //          ->setBedrooms(3)
    //          ->setDescription('Description')
    //          ->setSurface(60)
    //          ->setFloor(4)
    //          ->setHeat(1)
    //          ->setCity('Caen')
    //          ->setAddress('Boulevard xxx')
    //          ->setPostalCode(14000);

    // $em = $this->getDoctrine()->getManager();
    // $em->persist($property);
    // $em->flush();

    $property = $this->repository->findAllVisible();
    dump($property);
    return $this->render('properties/index.html.twig', [
      'current_menu' => 'properties'
    ]);
  }
}