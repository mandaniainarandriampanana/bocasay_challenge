<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 * @Route("commande")
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     * @Route("/", name="commande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('AppBundle:Commande')->findAll();

        return $this->render('AppBundle:commande:index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new commande entity.
     *
     * @Route("/new", name="commande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            foreach($commande->getProduit() as $produit){
                $produit->setStock($produit->getStock() - 1);
            }
            $em->flush();
            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }
        return $this->render('AppBundle:commande:new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
            'error' => $form->getErrors(true)->__toString()
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     * @Route("/{id}", name="commande_show")
     * @Method("GET")
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('AppBundle:commande:show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     * @Route("/{id}/edit", name="commande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commande $commande)
    {
        $em = $this->getDoctrine()->getManager();
        $inBddCommande = $em->getRepository('AppBundle:Commande')->findOneById($commande->getId());
        $idsInbddProduit = [];
        
        foreach($inBddCommande->getProduit() as $inBddCommandeProduit){
            $idsInbddProduit[] = $inBddCommandeProduit->getId();
        }
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('AppBundle\Form\CommandeType', $commande,['data' => $inBddCommande]);
        $editForm->handleRequest($request);
        $idsProduit = [];
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($commande->getProduit() as $produit){
                if(!in_array($produit->getId(),$idsInbddProduit)){
                    $produit->setStock($produit->getStock() - 1);
                    $idsProduit[] = $produit->getId();
                    $em->persist($produit);
                }
            }
            foreach(array_diff($idsInbddProduit,$idsProduit) as $idPdeletedFromCommande){
                $produit = $em->getRepository('AppBundle:Produit')->findOneById($idPdeletedFromCommande);
                $produit->setStock($produit->getStock() + 1);
                $em->persist($produit);
            }
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }
        return $this->render('AppBundle:commande:edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error' => $editForm->getErrors(true)->__toString()
        ));
    }

    /**
     * Deletes a commande entity.
     *
     * @Route("/{id}", name="commande_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($commande->getProduit() as $produit){
                $produit->setStock($produit->getStock() + 1);
                $em->persist($produit);
            }
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
