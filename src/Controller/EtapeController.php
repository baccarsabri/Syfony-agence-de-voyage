<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Destination ;
use App\Entity\Ville;
use App\Entity\Etape;
use App\Entity\Circuit ;
use App\Repository\DestinationRepository ;
use App\Repository\VilleRepository ;
use App\Repository\EtapeRepository ;
use App\Repository\CircuitRepository ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EtapeType ;

class EtapeController extends AbstractController
{
    
    private $E;
    
    private $em;
    public function __construct (
    EtapeRepository $rep2, EntityManagerInterface $em){
        
        $this->E=$rep2;
        $this->em=$em;
    }
    /**
     * @Route("/etape", name="etape")
     */
    public function index()
    {
        return $this->render('etape/modif_etape.html.twig', [
            'controller_name' => 'EtapeController',
        ]);
    }

     /**
     * @Route("{id}/deleteEtape", name="etape_delete")
     * @param Etape $Etape
     * @return redirectResponse
     */
    public function delete_etape(Etape $e):RedirectResponse
    {
        $id_circuit=$e->getCircuitEtape()->getId();
        $em=$this->getDoctrine()->getManager();
        $em->remove($e);
        $em->flush();
        
        return $this->redirectToRoute("modifier_circuit", array('id'=> $id_circuit));

    }
    /**
     *  @Route("{id}/editEtape", name="modifier_etape")
     */
    public function edit_ville(Etape $e, Request $request){
        $id_circuit=$e->getCircuitEtape()->getId();
        $form1= $this->createForm(EtapeType ::class, $e);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()){
           $this->em->flush();
           return $this->redirectToRoute("modifier_circuit", array('id'=> $id_circuit));
        }
          return $this->render('etape/modif_etape.html.twig',[
              'etape'=>$e,
              'form'=>$form1->createView()
          ]);
     }
     /**
     *  @Route("/createEtape", name="ajouter_etape")
     */
    public function new_etape( Request $request){
        $dest=new Etape();
        $form= $this->createForm(EtapeType::class, $dest);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()){
           $this->em->persist($dest);
           $this->em->flush();
           return $this->redirectToRoute("circuit");
        }
        return $this->render('etape/new_etape.html.twig',[
            'dest'=>$dest,
            'form'=>$form->createView()
        ]);
    }
}
