<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/categor", name="category")
 */
class CategoryController extends AbstractController
{

    // Index
    // --
    // url : site.com/categories
    // name: category:index

    /**
     * @Route("ies", name=":index", methods={"HEAD","GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Liste des categories
        // --

        // $categories = $pdo->query("SELECT * FORM catalog_category");
        $categories = $categoryRepository->findAll();


        // Reponse HTTP
        // -- 

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }



    // Create
    // --
    // url : site.com/category
    // name: category:create

    /**
     * @Route("y", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request): Response
    {
        // Creation du forlmulaire
        // --

        // Nouvelle entité
        $category = new Category;

        // Creation du formulaire
        $form = $this->createForm(CategoryType::class, $category);
        // $a = $this->createForm(CategoryType::class, $category);

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
        //     $pdo->query("INSERT INTO category ('name') VALUE (\"".$name."\")");
        // }
        if ($form->isSubmitted() && $form->isValid())
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete sur l'objet $category modifié par le formulaire
            $em->persist( $category );

            // Execute la requete
            $em->flush();



            // Redirige l'utilisateur vers la page du categorie
            // --

            // Creation du message de validation de la requete
            $this->addFlash('success', "Le categorie ".$category->getName()." a été créé !");


            // Redirection
            return $this->redirectToRoute('category:read', [
                'id' => $category->getId()
            ]);

        }


        // Reposne HTTP
        // --

        // Creation de la vue du formulaire
        $form = $form->createView();
        // $b = $a->createView();

        return $this->render('category/create.html.twig', [

            // Transmission du formulaire à la vue twig
            'form' => $form,
            // 'c' => $b,

        ]);
    }



    // Read
    // --
    // url : site.com/category/42
    // name: category:read

    /**
     * @Route("y/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read(Category $category): Response
    {
        return $this->render('category/read.html.twig', [
            'category' => $category
        ]);
    }



    // Update
    // --
    // url : site.com/category/42/edit
    // name: category:update

    /**
     * @Route("y/{id}/edit", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update(Category $category, Request $request): Response
    {
        // Creation du forlmulaire
        // --

        // Nouvelle entité
        // /!\ l'entité est déja créée avec le paramètre $category de la méthode create()

        // Creation du formulaire
        $form = $this->createForm(CategoryType::class, $category);

        // On capte la methode de requête HTTP
        $form->handleRequest( $request );

        // Traitement du formulaire
        // --

        if ($form->isSubmitted() && $form->isValid())
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete sur l'objet $category modifié par le formulaire
            $em->persist( $category );

            // Execute la requete
            $em->flush();



            // Redirige l'utilisateur vers la page du categorie
            // --

            // Creation du message de validation de la requete
            $this->addFlash('success', "Le categorie ".$category->getName()." a été modifié !");


            // Redirection
            return $this->redirectToRoute('category:read', [
                'id' => $category->getId()
            ]);

        }


        // Reposne HTTP
        // --

        // Creation de la vue du formulaire
        $form = $form->createView();

        return $this->render('category/update.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }



    // Delete
    // --
    // url : site.com/category/42/delete
    // name: category:delete

    /**
     * @Route("y/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     */
    public function delete(Category $category, Request $request): Response
    {
        // Test de la methode HTTP / soumission du formulaire
        // --

        // Test la methode HTTP: doit etre "DELETE"
        if ($request->getMethod() == 'DELETE')
        {
            // Recupération du Manager d'Entité (Entity Manager)
            $em = $this->getDoctrine()->getManager();

            // Preparation de la requete de suppression sur l'objet $category 
            // /!\ on utilise "remove" et non "persist"
            $em->remove( $category );

            // Execute la requete
            $em->flush();


            // Redirection de l'utilisateur vers la liste des categories
            // --

            // Message flash de confirmation de la suppression
            $this->addFlash('success', "Le categorie ". $category->getName() ." à été supprimé.");

            // Redirection
            return $this->redirectToRoute('category:index');
        }


        // Affichage du message de confirmation d'execution de la suppression
        // --

        return $this->render('category/delete.html.twig', [
            'category' => $category,
        ]);
    }
}