<?php

namespace PanierBundle\Controller;

use PanierBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Endroid\QrCode\QrCode;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use PanierBundle\Entity\Coupon;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('PanierBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }
    public function mescommandeAction()
    {
       

        $em = $this->getDoctrine()->getManager();

          $user = $this->getUser();
          $commandes =    $user->getCommandes();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }
    public function factureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $commande = $em->getRepository('PanierBundle:Commande')->find($request->get("id"));
        $html = $this->renderView('PanierBundle:Default:pdf.html.twig', array(
            'commande'  => $commande,
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'commande.pdf'
        );
    
    }
    function genererChaineAleatoire($longueur = 10)
{
 return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($longueur/strlen($x)) )),1,$longueur);
}
    /**
     * Lists all commande entities.
     *
     */
    public function saveAction()
    {
        if($this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")){

        $commande = new Commande();
        $em = $this->getDoctrine()->getManager();

    $request = $this->get('request_stack')->getCurrentRequest();
    $session = $request->getSession();
    $panier = $session->get('panier');
    $somme = 0;
    $d = new \DateTime('now');
    $result = $d->format('Y-m-d');
    $user= $this->getUser();
    foreach($panier as $p) {
    $produit = $em->getRepository('GeneralBundle:Produitbou')->find($p->id);     
    $commande->addProduit( $produit );
    $somme = $somme + $produit->getPrix() * $p->qte ;
    }
    if ($request->get('cou') != '0' ) {
        $somme =  (int) $request->get('cou');
    }
    if ($somme > 500){
      
        $coupon = new Coupon();
        $random = $this->genererChaineAleatoire();
        $coupon->setCoupon($random);
        $coupon->setEtat('0');
        $coupon->setDisc('30');
        if ($somme > 1000){ 
            $coupon->setDisc('50');
        }
        if ($somme > 2000){ 
            $coupon->setDisc('100');
        }
        $em->persist($coupon);
        $em->flush();
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo($user->getEmail())
        ->setBody(
         "Bonjour merci de votre confiance voici votre coupon".$random
        )
   
    ;

    $this->get('mailer')->send($message); 
    }
    $normalizer = new DataUriNormalizer();
    $qrCode = new QrCode("date de commande ".$commande->getDate()."montant de commande".$commande->getMontant());//genirina qr mat3na
    $qrCode->writeFile(__DIR__.'/qrcode.png');
    $avatar = $normalizer->normalize(new \SplFileObject(__DIR__.'/qrcode.png'));
    $commande->setQrcode($avatar);
    $commande->setDate($result);
    $commande->setMontant($somme);
    $commande->setAdress($request->get('address'));

    $commande->setUserid($this->getUser());
    $user = $this->getUser();
    $user->addCommandes($commande);
    $em->persist($user);
    $em->persist($commande);
    $em->flush();

    $session->set('panier' , array());


    return $this->redirectToRoute('commande_show', array('id' => $commande->getId())); }
    else {
        return $this->redirectToRoute('fos_user_security_login'); }
         }

    /**
     * Creates a new commande entity.
     *
     */
    public function newAction(Request $request)
    {
            if($this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")){

        $commande = new Commande();
        $form = $this->createForm('PanierBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }

        return $this->render('commande/new.html.twig'
        ); }
        else {
            return $this->redirectToRoute('fos_user_security_login'); }
    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('PanierBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

      //  if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
       // }

        return $this->redirectToRoute('mes_commande');
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
