<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BlogController extends Controller
{
    /**
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction($id)
    {
      $em = $this->getDoctrine()->getManager();

      $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

      if(!$blog)
        {
          throw $this->createNotFoundException('Unable to find Blog post.');
        }

      return array(
                   'blog' => $blog,
                   );
    }

}
