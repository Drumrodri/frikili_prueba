<?php

namespace App\Controller;
use App\Entity\User; //importamos la entidad o trabla usuario
use App\Form\UserType; //importamos el formulario
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; //codificar pass

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="app_registro")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        //create form para crear formularios
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        //condicional para el formulario
        if($form->isSubmitted() && $form->isValid()){
            //entity manage para guardar entidades en al bbdd
            $em = $this->getDoctrine()->getManager();
            //$user->setBaneado(false); //el estado predefinido comentado porque uso constructor en la entidad
            //$user->setRoles(['ROLE_USER']); //le metemos el rol predefinido
            $pass_form=$form['password']->getData(); //obtengo la pass del formulario
            //codificacion pass
            $codPassword = $passwordHasher->hashPassword(
                $user,
                $pass_form
            );
            $user->setPassword($codPassword);
            $em->persist($user);
            $em->flush();
            $this->addFlash('exito',User::REGISTRO_EXITOSO); //el texto se lo meto con una constante declarada en la entidad
            return $this->redirectToRoute('app_registro');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario'=>$form->createView(),
            
        ]);
    }
}
