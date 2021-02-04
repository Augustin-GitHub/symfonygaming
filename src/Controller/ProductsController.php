<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\PcstuffRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
        public function index(Request $request, PaginatorInterface $paginator, ProductRepository $productRepository, PcstuffRepository $pcstuffRepository):Response
        {
            $Entity = $this->getDoctrine()->getRepository(Product::class);
            $category = $pcstuffRepository->findAll();

            $Entities = $paginator->paginate(
                $Entity->findAll(), 

                $request->query->getInt('page', 1), 
                6 
            );

        $lastProduct = $productRepository->FindLastId();
       // dump($lastProduct);

        $lastProduct = $lastProduct[0];
       // dump($lastProduct);

        return $this->render('products/index.html.twig', [
            'Entities' => $Entities,
            'LastProduct' => $lastProduct,
            'categories' => $category,
        ]);
    }
}
