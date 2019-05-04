<?php

namespace App\Controller\Rest;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ClienteController extends FOSRestController
{
    /**
    * @param EntityManagerInterface $entityManager
    */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->clienteRepository = $entityManager->getRepository('App:Cliente');
    }
    /**
     * Recuperar un Cliente
     * @Rest\Get("/clientes/{clienteId}")
     */
    public function getCliente(int $clienteId): View
    {
        $cliente = $this->clienteRepository->findById($clienteId);
           
        if (!$cliente) {
            throw new EntityNotFoundException('Cliente con id '.$clienteId.' no existe!');
        }
        
        return View::create($cliente, Response::HTTP_OK);
    }
}