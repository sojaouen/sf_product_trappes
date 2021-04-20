<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product")
 */
class ProductController extends AbstractController
{
    // Index
    // --
    // url : site.com/products
    // name : product : index


   
    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
        ]);
    }

    // Create
    // --
    // url : site.com/product
    // name: product:create

    /**
     * @Route("", name=":create", methods={'HEAD","GET","POST"})
     */
    public function create(): Response
    {
        return $this->render('product/create.html.twig', [
        ]);
    }


    // Read
    // --
    // url : site.com/product/42
    // name: product:read

    /**
     * @Route("/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read(): Response
    {
        return $this->render('product/read.html.twig', [
        ]);
    }

    // Update
    // --
    // url : site.com/product/42/edit
    // name: product:update

    /**
     * @Route("/{id}/edit", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update(): Response
    {
        return $this->render('product/update.html.twig', [
        ]);
    }

    // Delete
    // --
    // url : site.com/product/42/delete
    // name: product:delete

        /**
     * @Route("/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     */
    public function delete(): Response
    {
        return $this->render('product/delete.html.twig', [
        ]);
    }
}
