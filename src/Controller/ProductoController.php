<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductoFormType;
use App\Entity\Producto;

/**
 * @Route("/producto", name="")
 */
class ProductoController extends AbstractController
{
    /**
    * @param EntityManagerInterface $entityManager
    */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->productoRepository = $entityManager->getRepository('App:Producto');
    }

    /**
     * @Route("/nuevo", name="nuevo_producto")
     */
    public function crearAction(Request $request)
    {
        $producto = new Producto();

        $form = $this->createForm(ProductoFormType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $producto = $form->getData();

            $this->entityManager->persist($producto);
            $this->entityManager->flush($producto);
    
            $this->addFlash('success', 'Producto Guardado con éxito');
    
            return $this->redirectToRoute('nuevo_producto');
        }

        return $this->render('/producto/producto.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listar", name="listar_productos")
     */
    public function listarAction(Request $request)
    {
        return $this->render('/producto/listar.html.twig', [
            'productos' => $this->productoRepository->findAll()
        ]);
    }

    /**
     * @Route("/editar/{id_producto}", name="editar_producto")
     */
    public function editarAction(Request $request, $id_producto)
    {
        $producto = $this->productoRepository->find($id_producto);

        $form = $this->createForm(ProductoFormType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $producto->setNombre($data->getNombre());
            $producto->setPrecio($data->getPrecio());

            $this->entityManager->persist($producto);
            $this->entityManager->flush($producto);
    
            $this->addFlash('success', 'Producto Editado con éxito');
    
            return $this->redirectToRoute('listar_productos');
        }

        return $this->render('/producto/producto.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
