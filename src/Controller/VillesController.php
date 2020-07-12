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
use App\Form\DestinationType;
use App\Form\VilleType ;

class VillesController extends AbstractController
{
    private $v;
    private $em;
    public function __construct (VilleRepository $rep1,
     EntityManagerInterface $em){
        
        $this->v=$rep1;
        
        $this->em=$em;
    }
    /**
     * @Route("/villes", name="villes")
     */
    public function index()
    {
        return $this->render('villes/index.html.twig', [
            'controller_name' => 'VillesController',
        ]);
    }
    /**
     * @Route("{id}/deleteville", name="ville_delete")
     * @param Ville $Ville
     * @return redirectResponse
     */
    public function delete_ville(Ville $v):RedirectResponse
    {
        $id_dest=$v->getDestVille()->getId();
        $em=$this->getDoctrine()->getManager();
        $em->remove($v);
        $em->flush();
        
        return $this->redirectToRoute("modifier_dest", array('id'=> $id_dest));

    }
    /**
     *  @Route("{id}/editVille", name="modifier_ville")
     */
    public function edit_ville(Ville $v, Request $request){
        $id_dest=$v->getDestVille()->getId();
        $form1= $this->createForm(VilleType ::class, $v);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()){
           $this->em->flush();
           return $this->redirectToRoute("modifier_dest", array('id'=> $id_dest));
        }
          return $this->render('villes/modif_ville.html.twig',[
              'ville'=>$v,
              'form'=>$form1->createView()
          ]);
     }
     /**
     *  @Route("/creat_ville", name="ajouter_ville")
     */
    public function new_dest( Request $request ){
        
        $v=new Ville();
        $form= $this->createForm(VilleType::class, $v);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
           $this->em->persist($v);
           $this->em->flush();
           return $this->redirectToRoute("index");
        }
        return $this->render('villes/new_ville.html.twig',[
            'Ville'=>$v,
            'form'=>$form->createView()
        ]);
    }
}
