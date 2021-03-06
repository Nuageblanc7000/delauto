<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Image;
use App\Form\AddCarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ShowRoomController extends AbstractController
{
    /**
     * Permet d'afficher toutes mes voitures
     * @Route("/show", name="showroom")
     * @return Response
     */
    public function index(CarRepository $repo): Response
    {
        return $this->render('show_room/cars.html.twig', [
            'cars' => $repo->findAll()
        ]);
    }


    /**
     * ajouter une voiture
     * @Route("/show/addCars",name="addCar")
     * @param Car $car
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function addCar(Request $request,EntityManagerInterface $manager){
        $car = new Car();

        $form = $this->createForm(AddCarType::class,$car);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            foreach ($car->getImages() as $image) {
                $image->setCar($car);
                $manager->persist($image);
            }
            
            $manager->persist($car);
            $manager->flush();

            $this->addFlash('success',
            'la voiture à bien été ajoutée');

        }

      return  $this->render('show_room/addCar.html.twig',[
            'myForm' => $form->createView()
        ]);

    }


    /**
     * permet la modification d'une annonce de voiture (paramConverter)
     * @Route("/show/{slug}/edit",name="edit_car")
     * @IsGranted("ROLE_ADMIN",message="Vous n'avez pas accès à cette partie")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Car $car
     * @return Response
     */
    public function editCar(Request $request,EntityManagerInterface $manager,Car $car){
        
        $form = $this->createForm(AddCarType::class, $car);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $car->getSlug('');
            foreach($car->getImages() as $image)
            {
                $image->setCar($car);
                $manager->persist($image);
            }
            
            
            $manager->persist($car);
            $manager->flush();
            
            $this->addFlash('success',
            
            "votre annonce {$car->getSlug()} à bien été modifiée"
        );
        return $this->redirectToRoute('showCar',[
            'slug' => $car->getSlug()
        ]);
    }
    
    return $this->render('show_room/editCar.html.twig',[
        'car' => $car,
        'myForm' => $form->createView()
    ]);
}

/**
 * permet la suppression d'une annonce de voiture
 * @Route("/show/{slug}/delete",name="delete_car")
 * @IsGranted("ROLE_ADMIN",message="Vous n'avez pas accès à cette partie")
 * @param Request $request
 * @param EntityInterfaceManager $manager
 * @param Car $car
 * @return Reponse
 */
public function deleteCar(EntityManagerInterface $manager,Car $car){
    
    $this->addFlash('success',
    "votre annonce {$car->getSlug()}"
    );
    $manager->remove($car);
    $manager->flush();
    
   return $this->redirectToRoute('showroom');
}

/**
 * permet d'afficher une voiture (param converter)
 * 
 * @Route("/show/{slug}",name="showCar")
 * 
 * @param Car $car
 * @return response
 */
public function showCar(Car $car){
    return $this->render('show_room/showCar.html.twig',[
        'car' => $car
    ]);
}
}
