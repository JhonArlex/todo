<?php
namespace App\Controller;
header("Access-Control-Allow-Origin: *");
use App\Entity\Listas;
use App\Entity\Tareas;
use App\Form\TareasType;
use App\Repository\ListasRepository;
use App\Repository\TareasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @Route("/tareas")
 */
class TareasController extends AbstractController
{
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/", name="tareas_index", methods={"GET"})
     */
    public function index(TareasRepository $tareasRepository, ListasRepository $listasRepository, Request $request): Response
    {
        $idList = $request->query->get('id');
        if ($idList != null) {
            $this->session->set('lista', $idList);
        }

        if ($this->session->get('lista') == null) {
            return $this->redirectToRoute('listas_index');
        }

        return $this->render('tareas/index.html.twig', [
            'tareas' => $tareasRepository->findBy(['lista' => $this->session->get('lista')]),
            'listas' => $listasRepository->findBy(['usuario' => $this->session->get('idUser')]),
        ]);
    }

    /**
     * @Route("/new", name="tareas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->session->get('lista') == null) {
            return $this->redirectToRoute('listas_index');
        }
        $tarea = new Tareas();
        $form = $this->createForm(TareasType::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tarea->setFechaVencimiento(new \DateTime());
            $tarea->setEstado('abierto');

            $repository = $this->getDoctrine()->getRepository(Listas::class);
            $lista = $repository->find($this->session->get('lista'));

            $tarea->setLista($lista);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tarea);
            $entityManager->flush();

            return $this->redirectToRoute('tareas_index');
        }

        return $this->render('tareas/new.html.twig', [
            'tarea' => $tarea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tareas_show", methods={"GET"})
     */
    public function show(Tareas $tarea): Response
    {
        return $this->render('tareas/show.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tareas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tareas $tarea): Response
    {
        $form = $this->createForm(TareasType::class, $tarea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tareas_index');
        }

        return $this->render('tareas/edit.html.twig', [
            'tarea' => $tarea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tareas_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tareas $tarea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tarea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tareas_index');
    }

    /**
     * @Route("/api/autocomplete", name="tareas_autocomplet", methods={"GET"})
     */
    public function autcomplete(Request $request, TareasRepository $tareasRepository) {
        $word = $request->query->get('word');
        $tareas = $tareasRepository->findAllMatching($word);
        $responseData = [
            'status' => true,
            'data'   => $tareas
        ];
        
        return new Response(json_encode($responseData));
    }
}
