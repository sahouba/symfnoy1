<?php
// version 3 : namespace App\bundel

// namespace ?
namespace App\Controller;
use  Symfony\Component\HttpFoundation\Response;
class DefaultController
{
    private $message ='le routage symfony est excellent!';
    private $messages = array(
      'Ruby on Rails est un fraework ruby',
      'message2',
      'Rmessage3'
     );
      public function index()
      {
          return new Response('<h1> bienvenu a Symfony </h1>');
      }
      public function home()
      {
        $html ='<h1> SYMFONY </h2>';
        $html .='<p> Simple paragraphe </p>';
        $res =new Response();
        $res->setContent($html);
        return $res;
      }
      public function bravo()
       {
      /*  $html ='<h1> le routage Symfony est excellent!</h1>';
        $res =new Response();
        $res->setContent($html);
        return $res;*/
        return new Response('<p>Message:'.$this->messages[0].'</p>');
      }
}
