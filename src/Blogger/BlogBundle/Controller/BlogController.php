<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/post")
 */
class BlogController extends Controller
{
  /**
   * @Route("/{id}/{slug}", requirements={"id" = "\d+"}, name="blog_show_by_id_slug")
   * @Template()
   */
  public function showAction($id, $slug)
  {
    $em = $this->getDoctrine()->getManager();
    
    $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
    
    if(!$blog)
      {
        throw $this->createNotFoundException('Unable to find Blog post.');
      }

    $comments = $em->getRepository('BloggerBlogBundle:Comment')
      ->getCommentsForBlog($blog->getId());

    return array(
                 'blog' => $blog,
                 'comments' => $comments,
                 );
  }

}
