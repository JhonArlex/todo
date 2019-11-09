<?php

namespace App\Controller;

use App\Entity\Listas;
use App\Entity\Usuario;
use App\Form\ListasType;
use App\Repository\ListasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/listas")
 */
class ListasController extends AbstractController
{

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="listas_index", methods={"GET"})
     */
    public function index(ListasRepository $listasRepository): Response
    {
        return $this->render('listas/index.html.twig', [
            'listas' => $listasRepository->findBy(['usuario' => $this->session->get('idUser')]),
        ]);
    }

    /**
     * @Route("/new", name="listas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lista = new Listas();
        $form = $this->createForm(ListasType::class, $lista);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lista->setFechaCreacion(new \DateTime());

            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $repository->find($this->session->get('idUser'));

            $lista->setUsuario($usuario);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lista);
            $entityManager->flush();

            return $this->redirectToRoute('tareas_index', ['id' => $lista->getId()]);
        }

        return $this->render('listas/new.html.twig', [
            'lista' => $lista,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="listas_show", methods={"GET"})
     */
    public function show(Listas $lista): Response
    {
        return $this->render('listas/show.html.twig', [
            'lista' => $lista,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="listas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Listas $lista): Response
    {
        $form = $this->createForm(ListasType::class, $lista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listas_index');
        }

        return $this->render('listas/edit.html.twig', [
            'lista' => $lista,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="listas_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Listas $lista): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lista->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lista);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listas_index');
    }
}
