<?php

namespace PanierBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GeneralBundle\Entity\Produitbou;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findAll();

        return $this->render('produitbou/index.html.twig', array(
            'produitbous' => $produitbous,
        ));
    }
        
   

    public function montantAction(Request $req) {
        $em = $this->getDoctrine()->getManager();
        $somme = 0;
        $request = $this->get('request_stack')->getCurrentRequest();
        $session = $request->getSession();
        
        $panier = $session->get('panier');
        $result = array();
        foreach($panier as $p) {
         $produit = $em->getRepository('GeneralBundle:Produitbou')->find($p->id);     
         $somme = $somme + $produit->getPrix() * $p->qte ;
        }
    
    
        return new Response(
            $somme
        ); 
     
        }
        
public function AddAction(Request $req) {
         
$request = $this->get('request_stack')->getCurrentRequest();
$session = $request->getSession();
$object = new \stdClass();
$em = $this->getDoctrine()->getManager();
$id = $req->get("id");
$produit = $em->getRepository('GeneralBundle:Produitbou')->find($id);
if ($req->get("qte") > $produit->getQtetotal() ){
    return new Response(
        "-1"
    );
}

if(!$session->has('panier'))
{
    $session->set('panier' , array());
}
$object->id = $req->get("id");
$object->qte = $req->get("qte");

$index = true;
$panier = $session->get('panier');
foreach($panier as $p) {
    if ($p->id == $object->id  ) {
        $p->qte = $p->qte + $object->qte ;
        $session->set('panier' ,$panier);
        $index = false;
    }
}
if ($index) {
array_push($panier, $object);
$session->set('panier' ,$panier);
    }
    $result = array();
    foreach($panier as $p) {
        $produit = $em->getRepository('GeneralBundle:Produitbou')->find($p->id);     
        array_push($result,[$produit->getId(),$p->qte,$produit->getNom(),$produit->getImage(),$produit->getDescription(),$produit->getPrix(),$produit->getQtetotal()]);
        }
        return new Response(json_encode($result));
}

public function getAction(Request $req) {
    $em = $this->getDoctrine()->getManager();

    $request = $this->get('request_stack')->getCurrentRequest();
    $session = $request->getSession();
    
    if(!$session->has('panier'))
    {
        $session->set('panier' , array());
    }
    
    $panier = $session->get('panier');
    $result = array();
    foreach($panier as $p) {
    $produit = $em->getRepository('GeneralBundle:Produitbou')->find($p->id);     
    array_push($result,[$produit->getId(),$p->qte,$produit->getNom(),$produit->getImage(),$produit->getDescription(),$produit->getPrix(),$produit->getQtetotal()]);
    }


    return new Response(json_encode($result));

    }
    public function emptyAction(Request $req) {
         
        $request = $this->get('request_stack')->getCurrentRequest();
        $session = $request->getSession();
        
        $session->set('panier' , array());
        $panier = $session->get('panier');
        json_encode($panier);
        
        return new JsonResponse($panier);
    
        }
       
    
        public function deleteAction(Request $req) {
            $em = $this->getDoctrine()->getManager();

            $request = $this->get('request_stack')->getCurrentRequest();
            $session = $request->getSession();
            $object = new \stdClass();
            $object->id = $req->get("id");
            $object->qte = $req->get("qte");
            
            $panier = $session->get('panier');
            $t = 0;$test =0;
            foreach($panier as $p) {
                $t++;
                if ($p->id == $object->id  ) {
                    $p->qte = $p->qte - $object->qte ;
                    if (0 > $p->qte ) {
                        $p->qte = 0;
                        $test = 1;
                        break;
                    }
                  
                }
            }
            if ($test == 1) {
                var_dump($t);
                unset($panier[$t-1]);
               }
            $session->set('panier' ,$panier);
           
                return new Response("");
        }
        public function couponAction(Request $request)
        {
            $em = $this->getDoctrine()->getManager();
            $produit = $em->getRepository('PanierBundle:Coupon')->findOneByCoupon($request->get('coupon'));
           
            if ($produit->getEtat()=="0"){
                $produit->setEtat("1");
                $em->flush();
                $somme = 0;
                $request = $this->get('request_stack')->getCurrentRequest();
                $session = $request->getSession();
                
                $panier = $session->get('panier');
                $result = array();
                foreach($panier as $p) {
                 $produi = $em->getRepository('GeneralBundle:Produitbou')->find($p->id);     
                 $somme = $somme + $produi->getPrix() * $p->qte ;
                }

                $prix = (integer) $produit->getDisc();
                return new Response($somme-$prix);
            }
            else {
                return new Response(0);

            }
    
        }
}
