<?php

namespace LocationBundle\Controller;

use LocationBundle\Entity\Velo;

use LocationBundle\Form\VeloType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

class VeloController extends Controller
{
    public function indexAction()
    {    $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();
        return $this->render('LocationBundle:Velo:index.html.twig', array('velo' => $vel));
    }

    public function editAction(Request $request,$id)
    {
        $ptrel = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findAll();

        $entityManager = $this->getDoctrine()->getManager();
        $velo = $entityManager->getRepository('LocationBundle:Velo')->findOneById($id);

        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici

            $velo->setConstructeur($request->get('constructeur'));
            $velo->setEtat($request->get('etat'));
            $velo->setModel($request->get('model'));
            $velo->setPrix($request->get('prix'));
            if($request->files->get('image') !=null) {
                $fich = $request->files->get('image');
                $new_name = rand() . '.' . $fich->getClientOriginalExtension();

                //remove file
                $filesystem = new Filesystem();
                $filesystem->remove($this->getParameter('image_directory')."/".$velo->getImage());
                $velo->setImage($new_name);
            }else  $velo->setImage($velo->getImage());

            $entityManager->flush();
            $this->addFlash('success', 'Vélo Modifiée avec succés');
            return $this->redirectToRoute('velo_index');
        }



        return $this->render('LocationBundle:Velo:edit.html.twig', array('form' => $form->createView(),"velo"=>$velo , 'ptrel' => $ptrel));
    }

    public function deleteAction(Request $request, Velo $velo)
    {  $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine()->getManager();
        $em->remove($velo);
        $em->flush();
        $this->addFlash('success', 'Réservation Supprimée');

        return $this->redirectToRoute('velo_index');
    }



    public function showAction($id)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findOneById($id);;
        return $this->render('LocationBundle:Velo:show.html.twig', array('velo' => $vel));

    }

    public function ajouterAction(Request $request)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->findAll();


        $velo = new Velo();
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();

            $matricule = rand().'-BASKEL-'.date('Y', time());
            $velo->setMatricule($matricule);
            $velo->setConstructeur($request->get('constructeur'));
            $velo->setEtat($request->get('etat'));
            $velo->setModel($request->get('model'));
            $velo->setPrix($request->get('prix'));
            $fich = $request->files->get('image');
            $new_name = rand() . '.' . $fich->getClientOriginalExtension();
            $fich->move($this->getParameter('image_directory'), $new_name);
            $velo->setImage($new_name);
            $pointRelais = $this->getDoctrine()->getRepository('LocationBundle:Pointlocation')->find($request->get('ptl'));

            $velo->setIdPoint($pointRelais);

            $em->persist($velo);
            $this->addFlash('success', 'Vélo ajoutée avec succés');
            $em->flush() ;
            return $this->redirectToRoute('velo_index');
        }

        return $this->render('LocationBundle:Velo:ajouter.html.twig', array('form' => $form->createView(), 'ptrel' => $vel));
    }

}
