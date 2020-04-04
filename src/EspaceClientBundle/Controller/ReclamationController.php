<?php

namespace EspaceClientBundle\Controller;

use EspaceClientBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * Reclamation controller.
 *
 */
class ReclamationController extends Controller
{

    public function index2Action()
    {   $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository('EspaceClientBundle:Reclamation')->findAll();
        $html = $this->renderView('EspaceClientBundle:Default:pdf.html.twig', array(
            'reclamations'  => $reclamations
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'reclamation.pdf'
        );
    
}
    /**
     * Lists all reclamation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository('EspaceClientBundle:Reclamation')->findAll();

        return $this->render('reclamation/index.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }

    /**
     * Creates a new reclamation entity.
     *
     */
    public function newAction(Request $request)
    {
        $reclamation = new Reclamation();
       $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('EspaceClientBundle:Produit')->find($request->get("idvelo"));

        $form = $this->createForm('EspaceClientBundle\Form\ReclamationType', $reclamation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setProduit($produit);
            $reclamation->setEtat("0");
            $user = $produit->getIdClient();
            $user->setReclamation($user->getReclamation()+1);
            if ($user->getReclamation() == 3) {
            $user->setEnabled(false);
            $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($produit->getEmail())
            ->setBody(
             "Bonjour votre compte a été baner a cause de trop reclamation"
            )
        ;
    $this->get('mailer')->send($message); 
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();

            return $this->redirectToRoute('espace_client_homepage');
        }

        return $this->render('reclamation/new.html.twig', array(
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reclamation entity.
     *
     */
    public function showAction(Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);

        return $this->render('reclamation/show.html.twig', array(
            'reclamation' => $reclamation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reclamation entity.
     *
     */
    public function editAction(Request $request, Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('EspaceClientBundle\Form\ReclamationType', $reclamation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_edit', array('id' => $reclamation->getId()));
        }

        return $this->render('reclamation/edit.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reclamation entity.
     *
     */
    public function deleteAction(Request $request, Reclamation $reclamation)
    {
        $form = $this->createDeleteForm($reclamation);
        $form->handleRequest($request);

       // if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamation);
            $em->flush();
       // }

        return $this->redirectToRoute('reclamation_index');
    }

    /**
     * Creates a form to delete a reclamation entity.
     *
     * @param Reclamation $reclamation The reclamation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reclamation $reclamation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamation_delete', array('id' => $reclamation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
