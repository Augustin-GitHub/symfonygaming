<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @Route("/products/modifier/{id}", name="edit")
     */
    public function edit(Request $request, Product $Product): Response
    {
        $form = $this->createForm(AddProductFormType::class, $Product);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            // Upload
            $image = $form->get('image')->getData();// On récupère la valeur du champ
            if($image){// Si on upload une image dans l'annnonce
                // On doit vérifier si une ancienne image est présente pour la supprimer
                // On fera attention de ne pas supprimer default.jpg et les fixtures

                // On est donc sûr de supprimer uniquement les images des utilisateurs
                $defaultImages = ['default.png', 'fixtures/1.png',  'fixtures/2.png',  'fixtures/3.png',
                    'fixtures/4.png', 'fixtures/5.png', 'fixtures/6.png', 'fixtures/7.png',
                    'fixtures/8.png', 'fixtures/9.png'];

                if($Product->getImage() && !in_array($Product->getImage(), $defaultImages)) {
                    // FileSystem permet de manipuler les fichiers
                    $fs = new Filesystem();
                    // On supprime l'ancienne image
                    $fs->remove($this->getParameter('upload_directory').'/'.$Product->getImage());
                }
                $filename = uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $filename);
                $Product->setImage($filename);
            }


            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirecttoRoute('products');
        }


        return $this->render('edit/index.html.twig', [
            'AddProductFormType' => $form->createView(),
            'Product' => $Product,
        ]);
    }
}