<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Form\PedidoFormType;
use App\Entity\Pedido;
use App\Entity\Producto;

/**
 * @Route("/pedido", name="")
 */
class PedidoController extends AbstractController
{
    /**
    * @param EntityManagerInterface $entityManager
    */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->pedidoRepository = $entityManager->getRepository('App:Pedido');
    }

    /**
     * @Route("/nuevo", name="nuevo_pedido")
     */
    public function crearAction(Request $request)
    {
        $pedido = new Pedido();

        $form = $this->createForm(PedidoFormType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pedido = $form->getData();

            $this->entityManager->persist($pedido);
            $this->entityManager->flush($pedido);
    
            $this->addFlash('success', 'Pedido Guardado con éxito');
    
            return $this->redirectToRoute('nuevo_pedido');
        }

        return $this->render('/pedido/pedido.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listar", name="listar_pedidos")
     */
    public function listarAction(Request $request)
    {
        return $this->render('/pedido/listar.html.twig', [
            'pedidos' => $this->pedidoRepository->findAll()
        ]);
    }

    /**
     * @Route("/editar/{id_pedido}", name="editar_pedido")
     */
    public function editarAction(Request $request, $id_pedido)
    {
        $pedido = $this->clienteRepository->find($id_pedido);

        $form = $this->createForm(PedidoFormType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pedido->setImporte($data->getImporte());

            $this->entityManager->persist($pedido);
            $this->entityManager->flush($pedido);
    
            $this->addFlash('success', 'Pedido Editado con éxito');
    
            return $this->redirectToRoute('listar_pedidos');
        }

        return $this->render('/pedido/pedido.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
