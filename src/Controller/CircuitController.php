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
use App\Form\CircuitType ;


class CircuitController extends AbstractController
{
    private $E;
    private $C;
    private $em;
    public function __construct (CircuitRepository $rep3,EtapeRepository $e , EntityManagerInterface $em){
        $this->E=$e;
        $this->C=$rep3;
       
        $this->em=$em;
    }
    /**
     * @Route("/circuit", name="circuit")
     */
    public function index()
    {
        $Circuit=$this->C->find_Circuits();
        return $this->render('circuit/index.html.twig', [
            'controller_name' => 'CircuitController',
            'Circuits'=>array('Circuit'=>$Circuit)
        ]);
    }
    /**
     * @Route("{id}/deleteCircuit", name="circuit_delete")
     * @param Circuit $Circuit
     * @return redirectResponse
     */
    public function delete_ville(Circuit $c):RedirectResponse
    {
        
        $em=$this->getDoctrine()->getManager();
        $em->remove($c);
        $em->flush();
        
        return $this->redirectToRoute("circuit");

    }
    /**
     *  @Route("{id}/edit_Circuit", name="modifier_circuit")
     */
    public function edit_circuit(Circuit $c, Request $request){
        $form= $this->createForm(CircuitType::class, $c);
        $form->handleRequest($request);
        $etapes=$this->E->findByCircuit($c);
        if ($form->isSubmitted() && $form->isValid()){
           $this->em->flush();
           return $this->redirectToRoute("circuit");
        }
          return $this->render('circuit/modif_circuit.html.twig',[
              'circuit'=>$c,
              'etapes'=>array('etape'=>$etapes),
              'form'=>$form->createView()
          ]);
     }
     /**
     *  @Route("/createCircuit", name="ajouter_circuit")
     */
    public function new_etape( Request $request){
        $dest=new Circuit();
        $form= $this->createForm(CircuitType::class, $dest);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()){
           $this->em->persist($dest);
           $this->em->flush();
           return $this->redirectToRoute("circuit");
        }
        return $this->render('circuit/new_circuit.html.twig',[
            'dest'=>$dest,
            'form'=>$form->createView()
        ]);
    }
    
}
