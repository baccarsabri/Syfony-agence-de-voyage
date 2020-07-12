<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
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
use App\Form\DestinationType ;


class BlogController extends AbstractController
{
    private $dest_rep;
    private $v;
    private $E;
    private $C;
    private $em;
    public function __construct (DestinationRepository $rep,VilleRepository $rep1,
    EtapeRepository $rep2,CircuitRepository $rep3, EntityManagerInterface $em){
        $this->dest_rep=$rep ;
        $this->v=$rep1;
        $this->C=$rep3;
        $this->E=$rep2;
        $this->em=$em;
    }
    
    public function index()
    {
        $dest=$this->dest_rep->find_Dest();
        return $this->render('blog/Destination.html.twig', [
            'controller_name' => 'BlogController',
            'd'=>array('dest'=>$dest)
        ]);
    }
    /**
     *  @Route("/home", name="home")
     */
    public function home()
    {
        $des1=$this->v->findAll();
        dump($des1);
        $ville=$this->v->find(9);
        $destination=$ville->getDestVille()->getDesDest();
        $etapes=$ville->getEtapes();
        $ville1=$this->v->find(7);
        $destination1=$ville1->getDestVille()->getDesDest();
        $etapes1=$ville1->getEtapes();
        $ville2=$this->v->find(10);
        $destination2=$ville2->getDestVille()->getDesDest();
        $etapes2=$ville2->getEtapes();
              
       
    
        return $this->render('blog/home.html.twig',[
            'title'=>"Bienvenue Chez Nous",
            'destination'=>"Nous souhaitons que vous trouvez votre destination",
            't'=>array('destination'=>$destination, 'ville'=>$ville->getDesVille(),'etapes'=>$etapes,
            'destination1'=>$destination1, 'ville1'=>$ville1->getDesVille(),'etapes1'=>$etapes1,
            'destination2'=>$destination2, 'ville2'=>$ville2->getDesVille(),'etapes2'=>$etapes2)
            
        ]
       );
    }
   
    
    public function ville_no_circuit(){
        // pour la Question 1
        $vill=$this->v->find_ville_etape();
        // pour la question 2
        $vil=$this->v->find_ville_order();
        // pour la question 3 
        $hur=$this->E->findDureelonguehurghada();
        // suuprimer 
        // $del=$this->E->delete();
        // modifier 
       $modifier=$this->E->modif();
        
        return $this->render('blog/ville.html.twig', [
            'controller_name' => 'BlogController',
            'v'=>array('villes'=>$vill),
            'v1'=>array('v'=>$vil),
            'v2'=>array('hur'=>$hur)
            
            
        ]);
    }
  
    /**
     *  @Route("{id}/delete", name="dest_delete")
     * @param Destination $Destination
     * @return redirectResponse
     */
    public function delete_dest( Destination $Destination):RedirectResponse
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($Destination);
        $em->flush();

        return $this->redirectToRoute("index");

    }
    /**
     *  @Route("{id}/edit", name="modifier_dest")
     */
    public function edit_dest(Destination $dest, Request $request){
       
       $form= $this->createForm(DestinationType::class, $dest);
       $form->handleRequest($request);
       $villes=$this->v->findByDestination($dest);
       if ($form->isSubmitted() && $form->isValid()){
          $this->em->flush();
          return $this->redirectToRoute("index");
       }
         return $this->render('blog/modif_dest.html.twig',[
             'destination'=>$dest,
             'villes'=>array('villes'=>$villes),
             'form'=>$form->createView()
         ]);
    }
    /**
     *  @Route("/create", name="ajouter_dest")
     */
    public function new_dest( Request $request){
        $dest=new Destination();
        $form= $this->createForm(DestinationType::class, $dest);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()){
           $this->em->persist($dest);
           $this->em->flush();
           return $this->redirectToRoute("index");
        }
        return $this->render('blog/new_dest.html.twig',[
            'dest'=>$dest,
            'form'=>$form->createView()
        ]);
    }
}
