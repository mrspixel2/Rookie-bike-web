<?php

namespace LocationBundle\Controller;
use LocationBundle\Entity\Pointlocation;


use Symfony\Component\HttpFoundation\Request;
use LocationBundle\Form\PointlocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PointlocationController extends Controller
{
    public function indexAction()
    {    $vel = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findAll();
        return $this->render('LocationBundle:Pointlocation:index.html.twig', array('ptrel' => $vel));
    }

    public function editAction( Request $request,$id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $ptll = $entityManager->getRepository('LocationBundle:Pointlocation')->findOneByIdPoint($id);

        $form = $this->createForm(PointlocationType::class, $ptll);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $ptll->setRegion($request->get('Region'));
            $ptll->setNom($request->get('nom'));
            $ptll->setLangitude($long = $request->get('longitude'));
            $ptll->setLatitude($lat = $request->get('latitude'));
            $entityManager->flush();
            $this->addFlash('success', 'Points de Relais Modifiée avec succés');
            return $this->redirectToRoute('point_index');
        }
        return $this->render('LocationBundle:Pointlocation:edit.html.twig', array('form' => $form->createView(), "velo"=>$ptll));
    }

    public function ajouterAction(Request $request)

    {    $vel = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findAll();

        $ptll = new Pointlocation();
        $form = $this->createForm(PointlocationType::class,$ptll) ;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {//ici
            $em = $this->getDoctrine()->getManager();
            $ptll->setRegion($request->get('Region'));
            $ptll->setNom($request->get('nom'));
            $ptll->setLangitude($long = $request->get('longitude'));
            $ptll->setLatitude($lat = $request->get('latitude'));




            $em->persist($ptll);
            $this->addFlash('success', 'Points Relais ajoutée avec succés');
            $em->flush() ;
            return $this->redirectToRoute('point_index');
        }
        return $this->render('LocationBundle:Pointlocation:ajouter.html.twig', array('form' => $form->createView(),'ptrel'=>$vel));
    }

    public function deleteAction(Request $request, Pointlocation $pointlocation)
    {  $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine()->getManager();
        $em->remove($pointlocation);
        $em->flush();
        $this->addFlash('success', 'Réservation Supprimée');

        return $this->redirectToRoute('point_index');
    }


    public function showAction($id)
    {   $ptrell = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findAll();
        $ptrel = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findOneByIdPoint($id);
        $velo = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();

        return $this->render('LocationBundle:Pointlocation:show.html.twig', array('ptrel' => $ptrel,'velo'=>$velo,'ptrell'=>$ptrell));
    }



    public function cindexAction()

    {    $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();
        $ptrel = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findAll();
        return $this->render('LocationBundle:Client:cindex.html.twig',array('ptrel' => $ptrel,'velo' => $vel));
    }





}


