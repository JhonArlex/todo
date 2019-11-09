<?php

// src/Controller/LoginController
namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('login.html.twig', ['error' => 0]);
    }

    /**
     * @Route("/login/init")
     */
    public function init(Request $request, SessionInterface $session) {
        $correo = $request->request->get('correo');
        $contrasena = $request->request->get('contrasena');

        $repository = $this->getDoctrine()->getRepository(Usuario::class);

        $usuario = $repository->findOneBy([
            'email' => $correo,
            'contrasena' => $contrasena,
        ]);

        if ($usuario) {
            $session->set('idUser', $usuario->getId());
            $session->set('nombre', $usuario->getNombre());
            $session->set('email', $usuario->getEmail());
            return $this->redirectToRoute('listas_index');
        } else {
            return $this->redirectToRoute('login');
        }

    }
}

?>