<?php

namespace EspaceClientBundle\Controller;

use EspaceClientBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GeneralBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{
   
    /**
     * Lists all produit entities.
     *
     */
    public function indexAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EspaceClientBundle:Produit')->findBy(array('etat'=>'0'));

        if ($request->get('tri') == "prix") {
            usort($produits, array('EspaceClientBundle\Entity\Produit','cmp')); 

    }
    elseif ($request->get('tri') == "date") {
        usort($produits, array('EspaceClientBundle\Entity\Produit','cmp2')); 

    }

    foreach ($produits as $p) {
         $d =   strripos($p->getImage(),"/");
         $p->setImage(substr($p->getImage(),$d+1));
        }
 
       
        
        if  ($request->get('items') > 0) {
           $n = $request->get('items');
        }
        else {
            $n = 10;
        }
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produits,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', $n)
        );
        return $this->render('produit/index.html.twig', array(
            'produits' => $result,
        ));
    }
    
    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('EspaceClientBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $produit->setIdClient($user);
            $produit->setEmail($user->getEmail());
            $d = new \DateTime('now');
            $result = $d->format('Y-m-d');
 /** @var UploadedFile $file */
 $file = $produit->getImage();
 $filename = md5(uniqid()).'.'.$file->guessExtension();
 $file->move(
     $this->getParameter('image_directory'),$filename
 );
 $produit->setImage("file:/C:/wamp64/www/PIDEV/web/images/".$filename);
            $produit->setDate($result);
            $produit->setEtat("0");

            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('Espace_show', array('idvelo' => $produit->getIdvelo()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }
 /**
     * Finds and displays a produit entity.
     *
     */
    public function contacterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EspaceClientBundle:Produit')->find($request->get('idvelo'));
            $d =   strripos($produit->getImage(),"/");
            $produit->setImage(substr($produit->getImage(),$d+1));
           $user = $this->getUser();
        return $this->render('produit/contacter.html.twig', array(
            'produit' => $produit,
            'user' => $user,
        ));
    }
    public function EtatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EspaceClientBundle:Produit')->find($request->get('idvelo'));
            $produit->setEtat("1");
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('Espace_produit'); 

    }
    public function mailAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EspaceClientBundle:Produit')->find($request->get('idvelo'));
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo($produit->getEmail())
        ->setBody(
         "Bonjour ".$produit->getIdClient()->getFirstname()."\n\n".
         "Le client : ".$this->getUser()->getEmail()."\n\n".
         "vous contacter a propos de votre produit ".$produit->getNom()."\n\n".
         "continue ".$request->get('content')
        )
   
    ;

    $this->get('mailer')->send($message); 
    return $this->redirectToRoute('Espace_index'); 

       }
    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
      
            $d =   strripos($produit->getImage(),"/");
            $produit->setImage(substr($produit->getImage(),$d+1));
           
        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function mesproduitAction()
    {
        $produits = $this->getUser()->getProduits();
        foreach ($produits as $p) {
            $d =   strripos($p->getImage(),"/");
            $p->setImage(substr($p->getImage(),$d+1));
           }
      

           
        return $this->render('produit/mesproduit.html.twig', array(
            'produits' => $produits,
            
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('EspaceClientBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
             /** @var UploadedFile $file */
 $file = $produit->getImage();
 $filename = md5(uniqid()).'.'.$file->guessExtension();
 $file->move(
     $this->getParameter('image_directory'),$filename
 );
 $produit->setImage("file:/C:/wamp64/www/PIDEV/web/images/".$filename);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Espace_produit'); 
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
      
        return $this->redirectToRoute('Espace_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Espace_delete', array('idvelo' => $produit->getIdvelo())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function statAction(){
        $em = $this->getDoctrine()->getManager();
 //       $produits = $em->getRepository('EspaceClientBundle:Produit')->findAll();
   //     usort($produits, array('EspaceClientBundle\Entity\Produit','cmp2')); 
        
        $qb = $em->createQueryBuilder();

        $qb->select('u.date as a ,COUNT(u.date) as b')
   ->from('EspaceClientBundle\Entity\Produit', 'u')
   ->groupBy('u.date');

   $events = $qb->getQuery()->getArrayResult();

    
   $data = [];
 foreach($events as $e) {
  
   array_push($data,[$e["a"],(int)$e["b"]]);           
        }
        
    
        $ob = new Highchart();
        $ob->chart->renderTo('container');
        $ob->chart->type('pie');
        $ob->title->text('Taux de publication par jour');
        $ob->series(array(array("data"=>$data)));
    
        return $this->render('produit/stat.html.twig', [
            'mypiechart' => $ob
        ]);
    }
}
