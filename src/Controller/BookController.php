<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book", name="book")
 */
class BookController extends AbstractController
{

    // Index
    // --
    // url : site.com/books
    // name: book:index

    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        // Liste des produits
        // --

        // $books = $pdo->query("SELECT * FORM catalog_book");
        $books = $bookRepository->findAll();


        // Reponse HTTP
        // -- 

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }



    // Create
    // --
    // url : site.com/book
    // name: book:create

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request): Response
    {
        // Creation du forlmulaire
        // --

        // Nouvelle entité
        $book = new Book;

        // Creation du formulaire
        $form = $this->createForm(BookType::class, $book);
        // $a = $this->createForm(BookType::class, $book);

        // On capte la methode de requête HTTP
        $form->handleRequest( $request );

        // Traitement du formulaire
        // --

        // if ($_SERVER['REQUEST_METHOD'] === "POST")
        // {
        //     $name = $_POST['name'];
        //     $description = $_POST['description'];
        //     // Controle des données
        //     // Ajout en BDD
        //     $pdo->query("INSERT INTO book ('name') VALUE (\"".$name."\")");
        // }
        if ($form->isSubmitted() && $form->isValid())
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete sur l'objet $book modifié par le formulaire
            $em->persist( $book );

            // Execute la requete
            $em->flush();



            // Redirige l'utilisateur vers la page du produit
            // --

            // Creation du message de validation de la requete
            $this->addFlash('success', "Le produit ".$book->getTitle()." a été créé !");


            // Redirection
            return $this->redirectToRoute('book:read', [
                'id' => $book->getId()
            ]);

        }


        // Reposne HTTP
        // --

        // Creation de la vue du formulaire
        $form = $form->createView();
        // $b = $a->createView();

        return $this->render('book/create.html.twig', [

            // Transmission du formulaire à la vue twig
            'form' => $form,
            // 'c' => $b,

        ]);
    }



    // Read
    // --
    // url : site.com/book/42
    // name: book:read

    /**
     * @Route("/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read(Book $book): Response
    {
        return $this->render('book/read.html.twig', [
            'book' => $book
        ]);
    }



    // Update
    // --
    // url : site.com/book/42/edit
    // name: book:update

    /**
     * @Route("/{id}/edit", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update(Book $book, Request $request): Response
    {
        // Creation du forlmulaire
        // --

        // Nouvelle entité
        // /!\ l'entité est déja créée avec le paramètre $book de la méthode create()

        // Creation du formulaire
        $form = $this->createForm(BookType::class, $book);

        // On capte la methode de requête HTTP
        $form->handleRequest( $request );

        // Traitement du formulaire
        // --

        if ($form->isSubmitted() && $form->isValid())
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete sur l'objet $book modifié par le formulaire
            $em->persist( $book );

            // Execute la requete
            $em->flush();



            // Redirige l'utilisateur vers la page du produit
            // --

            // Creation du message de validation de la requete
            $this->addFlash('success', "Le produit ".$book->getTitle()." a été modifié !");


            // Redirection
            return $this->redirectToRoute('book:read', [
                'id' => $book->getId()
            ]);

        }


        // Reposne HTTP
        // --

        // Creation de la vue du formulaire
        $form = $form->createView();

        return $this->render('book/update.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }



    // Delete
    // --
    // url : site.com/book/42/delete
    // name: book:delete

    /**
     * @Route("/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     */
    public function delete(Book $book, Request $request): Response
    {
        // Test de la methode HTTP / soumission du formulaire
        // --

        // Test la methode HTTP: doit etre "DELETE"
        if ($request->getMethod() == 'DELETE')
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete de suppression sur l'objet $book 
            // /!\ on utilise "remove" et non "persist"
            $em->remove( $book );

            // Execute la requete
            $em->flush();


            // Redirection de l'utilisateur vers la liste des produits
            // --

            // Message flash de confirmation de la suppression
            $this->addFlash('success', "Le produit ". $book->getTitle() ." à été supprimé.");

            // Redirection
            return $this->redirectToRoute('book:index');
        }


        // Affichage du message de confirmation d'execution de la suppression
        // --

        return $this->render('book/delete.html.twig', [
            'book' => $book,
        ]);
    }
}