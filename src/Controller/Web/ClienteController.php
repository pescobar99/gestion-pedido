<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ClienteFormType;
use App\Entity\Cliente;
use GuzzleHttp\Client;

/**
 * @Route("/cliente", name="")
 */
class ClienteController extends AbstractController
{
    /**
    * @param EntityManagerInterface $entityManager
    */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->clienteRepository = $entityManager->getRepository('App:Cliente');
        $this->http_client = new Client();
    }

    /**
     * @Route("/nuevo", name="nuevo_cliente")
     */
    public function crearAction(Request $request)
    {
        $cliente = new Cliente();

        $form = $this->createForm(ClienteFormType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cliente = $form->getData();

            $this->entityManager->persist($cliente);
            $this->entityManager->flush($cliente);
    
            $this->addFlash('success', 'Cliente Guardado con éxito');
    
            return $this->redirectToRoute('nuevo_cliente');
        }

        return $this->render('/cliente/cliente.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listar", name="listar_clientes")
     */
    public function listarAction(Request $request)
    {
        return $this->render('/cliente/listar.html.twig', [
            'clientes' => $this->clienteRepository->findAll()
        ]);
    }

    /**
     * @Route("/editar/{id_cliente}", name="editar_cliente")
     */
    public function editarAction(Request $request, $id_cliente)
    {
        $cliente = $this->clienteRepository->find($id_cliente);

        $form = $this->createForm(ClienteFormType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $cliente->setNombre($data->getNombre());

            $this->entityManager->persist($cliente);
            $this->entityManager->flush($cliente);
    
            $this->addFlash('success', 'Cliente Editado con éxito');
    
            return $this->redirectToRoute('listar_clientes');
        }

        return $this->render('/cliente/cliente.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id_cliente}/pedidos", name="listar_pedido_cliente")
     */
    public function getPedidoCliente($id_cliente) {
        $response = $this->http_client->request('GET', "http://gestion-pedidos.local/api/clientes/$id_cliente");
        $cliente = json_decode($response->getBody()->getContents());
        
        return $this->render('/cliente/listar_pedidos.html.twig', [
            'cliente' => $cliente[0]
        ]);
    }
}
