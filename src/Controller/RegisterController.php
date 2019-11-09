<?php

// src/Controller/RegisterController
namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('register.html.twig', ['errors' => []]);
    }

    /**
     * @Route("/register/create")
     */
    public function create(Request $request, ValidatorInterface $validator)
    {
        /**
         * Obtener datos del formulario
         */
        $contrasena = $request->request->get('contrasena');
        $recontrasena = $request->request->get('recontrasena');

        if ($contrasena != $recontrasena) {
            return $this->redirectToRoute('register', [
                'error' => true,
                'type' => 1
            ]);
        } 


        $usuario = new Usuario();

        $usuario->setEmail($request->request->get('correo'));
        $usuario->setNombre($request->request->get('nombre'));
        $usuario->setContrasena($contrasena);

        $errors = $validator->validate($usuario);

        if (count($errors) > 0) {
            return $this->render('register.html.twig', ['errors' => $errors]);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->redirectToRoute('login', ['register' => true]);
    }
}

?>