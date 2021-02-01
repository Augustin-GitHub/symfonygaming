<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteProductController extends AbstractController
{
    /**
     * @Route("/products/supprimer/{id}", name="delete_product")
     */
    public function delete(Product $Product): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Product);
        $entityManager->flush();

        $this->addFlash('danger', 'votre produit a bien été supprimé');
        return $this->redirectToRoute('products');
    }
}
