<?php
// version 3 : namespace App\bundel

// namespace ?
namespace App\Controller;
use  Symfony\Bundle\FrameworkBundle\Controller\Controller;
use  Symfony\Component\HttpFoundation\Response;
use  Symfony\Component\HttpFoundation\Request;
use App\Entity\Player;
class DemoController extends Controller
{
        public $players=
         [
                array('id'=>1,'name' => 'Pogba','num'=>6,'substitute' =>false,'img'=> "http://www.footmercato.net/images/a/paul-pogba-embrasse-la-coupe-du-monde_231878.jpg"  ),
                array('id'=>2,'name' => 'Lloris','num'=>1,'substitute'=>true, 'img'=> "http://www.footmercato.net/images/a/lloris-a-sorti-un-gros-match-contre-l-uruguay_231159.jpg" ),
                array('id'=>3,'name' => 'Mbappé','num'=>10,'substitute'=>false,'img'=> "http://www.sportune.fr/wp-content/uploads/2018/07/Mbappe-maillot-France-.jpg" )
         ];

        public function index()
         {
            $colors =['bleu','blanc','rouge'];
            return $this-> render('demo.html.twig', array(
             'title' => 'Demo template Twig',
             'message' =>'Simple message en provenance du controller',
             'available'=> true,'colors'=>$colors,'players'=>$this->players)); // là méthode render provient de la class controller

           //return  new Response('okk');
         }

        public function player($id)
          {
            // var_dump($id);
            // $id correspond au paramétre d'url {id}définit ds le ficher de routage.
            // à partir de l'identifiant ,on va récupérer la totalité des données  le joueur identifié.
            $player =null;
            foreach ($this->players as $p) {
              //joueur trouvé ds la source de données
              if($p['id']==$id){
                $player=$p;
              }
            }
            return $this->render('player.html.twig',array('player'=>$player));
          }

        public function players()
         {
          $p1 =new Player('Sahbi',10,true,'');
            $p2 =new Player('Cristiano Ronaldo',7,true,'');
              $p3 =new Player('Adil Rami',17,false,'');
          // $p1->setName("SAHBI");
          // $p1->setNum(10);
          // $p1->setSubstitute(false);

           //$this->addPlayers();

           // récupérer les joueurs en base de donnée
           // pour les requétes en lecture , on utillse getRepository()
           $repo = $this->getDoctrine()->getRepository(Player::class);
           $players = $repo->findAll();

          return $this->render('players.html.twig',array(
            'title' =>'Liste de joueurs',
            'players'=>[$p1,$p2,$p3],
            'players2'=>$players
          ));

         }

        public function addPlayers()
          {
            $p1=new Player('Pogba',6,false,"http://www.footmercato.net/images/a/paul-pogba-embrasse-la-coupe-du-monde_231878.jpg");
            $p2=new
            Player('Lloris',1,true,"http://www.footmercato.net/images/a/lloris-a-sorti-un-gros-match-contre-l-uruguay_231159.jpg");
            //getManager() fournit un objet gérant les requétes en écriture
            $em=$this->getDoctrine()->getManager();
            $em->persist($p1); // requéte pendante (en attente d'exécution)
            $em->persist($p2); // requéte pendante (en attente d'exécution)
            $em->flush();      // exécutions requéte pendantes
          }

        public function playerForm(Request $request)
        {
          // 2 case de figure
          // 1/GET =>affichage du formulaire
          //2/POST =>traitement de l'envoi du formulaire
          //récupérer les valeurs postées
        if ($request->isMethod('POST')) { // si la méthode HTTP de la requéte est post
          //  echo "POST";
          // POST
            //  var_dump($_POST);
             //var_dump($request);
             // l'objet $request permet d'obtenir des informations
             // sur la requéte
              //var_dump($request->request); version objet de var_dump($_POST);
              //var_dump($request->request->get('name'));
              $name      =$request->request->get('name');
              $num       =$request->request->get('num');
              $substitute=$request->request->get('substitute');
              $photo     =$request->request->get('photo');
              var_dump($substitute); //renvoie "NULL" si checkbox non cochée si cochée  il renvoi "on"
              if ($substitute != NULL) {
                $substitute=true;
              }else {
                $substitute=false;
              }
              //Enregistrement en DB
               $player=new Player($name,$num,$substitute,$photo);
               $em=$this->getDoctrine()->getManager();
               $em->persist($player); // requéte pendante (en attente d'exécution)
               $em->flush();      // exécutions requéte pendantes
               // redirection vers la route players2
               return $this->redirectToRoute('players');
          }else { // GET
            return $this->render('playerform.html.twig',array());
          }
        }
}
