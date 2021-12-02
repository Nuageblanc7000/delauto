<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    
    /**
     * Permet l'inscription au site
     * @Route("/inscription", name="inscription_user")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    public function inscription(EntityManagerInterface $manager,Request $request,UserPasswordHasherInterface $hasher): Response
    {
       $user = new User();
       $form = $this->createForm(UserType::class,$user);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
          $password = $user->getPassword();
           $user->setPassword($hasher->hashPassword($user,$password));
           $manager->persist($user);
           $manager->flush();
           $this->addFlash("success","Bienvenu {$user->getLastname()}");

           return $this->redirectToRoute('homepage');
       }
        
        return $this->render('user/inscription.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
    // /**
    //  * Permet à l'user de se connecter
    //  * @Route("/connection",name="connection_user")
    //  * @param Request $request
    //  * @param User $user
    //  * @return void
    //  */
    // public function connection(Request $request,UserInterface $user){
    //     $form= $this->createForm(ConnectionType::class,$user);
    //     $form->handleRequest($request);

    //     return $this->render('user/connection.html.twig',[
    //         'loginForm' => $form
    //     ]);
    // }
}
