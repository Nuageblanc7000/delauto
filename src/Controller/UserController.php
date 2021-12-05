<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    public $tokenStorage;   
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage=$tokenStorage;
    }

    
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

           return $this->redirectToRoute('profil_user');
       }
        
        return $this->render('user/inscription.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
    
    /**
     * afficher le profil du user en cours
     * @Route("/profil",name="profil_user")
     * @return Response
     */
    public function userProfil(){
     $user =  $this->getUser();

     return $this->render('user/profil.html.twig',[
         'user' => $user
     ]);
    }
    /**
     * Permet la modif du user en cours.
     * @Route("/profil/edit",name="edit_user")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function editProfil(EntityManagerInterface $manager, Request $request){
        $user = $this->getUser();
        $form = $this->createForm(EditUserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success text-center fs-4 fw-1','Votre profil à bien été modifié!');
            return $this->redirectToRoute('profil_user');
        }
        return $this->render('user/editUser.html.twig',[
            'userForm' => $form->createView()
        ]);
    }

    /**
     * delete un compte
     * @Route("/profil/del",name="del_user")
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delProfil(EntityManagerInterface $manager,Request $request){
     
        $user = $this->getUser();
        $request->getSession()->invalidate();
        $this->addFlash('primary text-center',"Votre compte à bien été supprimé. {$user->getFullName()},nous ésperons vous revoir vite.");
        $this->tokenStorage->setToken();
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute("login");
    }
}
