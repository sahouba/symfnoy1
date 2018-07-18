<?php

namespace App\Controller;
use  Symfony\Bundle\FrameworkBundle\Controller\Controller;
use  Symfony\Component\HttpFoundation\Response;
use  Symfony\Component\HttpFoundation\Request;
use App\Entity\Team;
class TeamController extends Controller
  {

    public function teams()
     {

       $repo = $this->getDoctrine()->getRepository(Team::class);
       $teams = $repo->findAll();

      return $this->render('team/list.html.twig',array(
        'title' =>'Liste de Teams',
        'teams'=>$teams
      ));

     }
    public function teamForm(Request $request)
    {

    if ($request->isMethod('POST')) {

          $name      =$request->request->get('name');
          $coach       =$request->request->get('coach');
          $foundationYear=$request->request->get('foundationYear');


          //Enregistrement en DB
           $team=new Team($name,$coach,$foundationYear);
           $em=$this->getDoctrine()->getManager();
           $em->persist($team); // requéte pendante (en attente d'exécution)
           $em->flush();      // exécutions requéte pendantes
           // redirection vers la route players2
           return $this->redirectToRoute('teams');
      }else { // GET
        return $this->render('team/form.html.twig',array());
      }
    }
  }
 ?>
