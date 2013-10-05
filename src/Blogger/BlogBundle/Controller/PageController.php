<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{
    /**
     * @Route("/", name="blogger_blog")
     * @Template()
     */
    public function indexAction()
    {
      return array(
                   'notaname' => 'not a name',
                   );
    }

    /**
     * @Route("/about", name="blogger_about")
     * @Template()
     */
    public function aboutAction()
    {
      return array(
                   'imahack' => 'isahack',
                   );
    }

}
