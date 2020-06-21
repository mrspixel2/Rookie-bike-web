<?php

namespace LocationBundle\Controller;
use LocationBundle\Entity\Res;
use LocationBundle\Entity\Velo;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use LocationBundle\Entity\Pointlocation;
use LocationBundle\Form\ResType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ResController extends Controller
{
    public function indexAction()
    {    $vel = $this->getDoctrine()->getRepository('LocationBundle:Res')->findAll();
        return $this->render('LocationBundle:Res:index.html.twig', array('velo'=> $vel));
    }

    public function editAction()
    {
        return $this->render('LocationBundle:Res:edit.html.twig', array(
            // ...
        ));
    }

    public function showAction($id)
    { $velo = $this->getDoctrine()->getRepository('LocationBundle:Res')->findOneByIdReservation($id);;
        $html = $this->renderView('@Location/Res/show.html.twig', array('velos'  => $velo));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }

    public function deleteAction(Request $request, $id)
    { $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('LocationBundle:Res')->find($id);
        $velo = $res->getIdVelo() ;

        $velo->setConstructeur($velo->getConstructeur());
        $velo->setEtat(1);
        $velo->setModel($velo->getModel());
        $velo->setPrix($velo->getPrix());
        $velo->setImage($velo->getImage());

        $em->remove($res);
        $em->flush();
        $this->addFlash('success', 'Réservation Supprimée');

        return $this->redirectToRoute('location_index');
    }

    public function ajouterAction(Request $request)
    {  $allvelo = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();
        $res = new Res();
        $form = $this->createForm(ResType::class, $res);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();
            $velo = $this->getDoctrine()->getRepository('LocationBundle:Velo')->find($request->get('vel')) ;
            $res->setId($this->getUser());
            $res->setIdVelo( $velo);
            $res->setDateres(new \DateTime($request->get('datel')));
            $res->setDatefin(new \DateTime($request->get('datef')));
            $res->setPrixtot($this->getDoctrine()->getRepository('LocationBundle:Velo')->find($request->get('vel'))->getPrix());
            $velo->setConstructeur($velo->getConstructeur());
            $velo->setEtat(0);
            $velo->setModel($velo->getModel());
            $velo->setPrix($velo->getPrix());
            $velo->setImage($velo->getImage());


            $em->persist($res);
            $this->addFlash('success', 'Reservation ajoutée avec succés ');
            $em->flush() ;
            return $this->redirectToRoute('client_liste');

    }
        return $this->render('LocationBundle:Res:ajouter.html.twig', array('form' => $form->createView(), 'velo' => $allvelo));
}

    public function reservationAction(Request $request,$id)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findOneById($id);;

        $res = new Res();
        $form = $this->createForm(ResType::class, $res);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();
            $velo = $this->getDoctrine()->getRepository('LocationBundle:Velo')->find($request->get('vel'));
            $res->setId($this->getUser());
            $res->setIdVelo($velo);
            $res->setDateres(new \DateTime($request->get('datel')));
            $res->setDatefin(new \DateTime($request->get('datef')));

            $res->setPrixtot($this->getDoctrine()->getRepository('LocationBundle:Velo')->find($request->get('vel'))->getPrix());
            $velo->setConstructeur($velo->getConstructeur());
            $velo->setEtat(0);
            $velo->setModel($velo->getModel());
            $velo->setPrix($velo->getPrix());
            $velo->setImage($velo->getImage());


            $em->persist($res);
            $this->addFlash('success', 'Reservation ajoutée avec succés ');
            $em->flush();

            return $this->redirectToRoute('client_liste');

        }
        return $this->render('LocationBundle:Client:reservation.html.twig', array('form' => $form->createView(),  'velo' => $vel));

    }
    public function listeAction()
    {    $vel = $this->getDoctrine()->getRepository('LocationBundle:Res')->findBy( array('idClient' => $this->getUser()->getId()));
        return $this->render('LocationBundle:Client:liste.html.twig', array('velo'=> $vel));
    }
}
