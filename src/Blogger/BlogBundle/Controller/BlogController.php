<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Blogger\BlogBundle\Entity\Blog;
use Blogger\BlogBundle\Form\BlogType;

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

  /**
   * Present a form to create a new Blog post
   *
   * @Route("/admin/new", name="blog_post_new")
   * @Template()
   * @Method("GET")
   */
  public function newAction()
  {
    $blog = new Blog();

    $form = $this->createForm(new BlogType(), $blog);
    
    return array(
                 'form' => $form->createView(),
                 );
  }

  /**
   * Process a submitted form to create a new Blog post
   *
   * @Route("/admin/create", name="blog_post_create")
   * @Method("POST")
   * @Template("BloggerBlogBundle:Blog:new.html.twig")
   */
  public function createAction(Request $request)
  {
    $blog = new Blog();

    $form = $this->createForm(new BlogType(), $blog);
    $form->bind($request);

    if($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);
        $em->flush();

        return $this->redirect($this->generateUrl('blog_show_by_id_slug', array(
                                                                                'id' => $blog->getId(),
                                                                                'slug' => $blog->getSlug(),
                                                                                )));
      }
    
    return array(
                 'form' => $form->createView(),
                 );
  }
   
  /**
   * Display a Blog post for editing
   *
   * @Route("/admin/{id}/{slug}/edit", requirements={"id" = "\d+"}, name="blog_post_edit")
   * @Template("BloggerBlogBundle:Blog:update.html.twig")
   * @Method("GET")
   */
  public function editAction(Request $request, $id, $slug)
  {
    $em = $this->getDoctrine()->getManager();

    $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

    if(!$blog)
      {
        throw $this->createNotFoundException('Unable to find Blog post.');
      }
    
    $form = $this->createForm(new BlogType(), $blog);
    
    return array(
                 'form' => $form->createView(),
                 'blog' => $blog,
                 );
              
  }

  /**
   * Updates a Blog post after submission
   *
   * @Route("/admin/{id}/{slug}/update", requirements={"id" = "\d+"}, name="blog_post_update")
   * @Method("POST")
   * @Template()
   */
  public function updateAction(Request $request, $id, $slug)
  {
    $em = $this->getDoctrine()->getManager();

    $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

    if(!$blog)
      {
        throw $this->createNotFoundException('Unable to find Blog post.');
      }

    $form = $this->createForm(new BlogType(), $blog);
    $form->bind($request);

    if($form->isValid())
      {
        $em->persist($blog);
        $em->flush();

        return $this->redirect($this->generateUrl('blog_show_by_id_slug', array(
                                                                                'id' => $blog->getId(),
                                                                                'slug' => $blog->getSlug(),
                                                                                )));
      }
    
    return array(
                 'form' => $form->createView(),
                 );
  }

}
