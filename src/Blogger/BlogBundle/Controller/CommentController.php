<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Blogger\BlogBundle\Entity\Comment;
use Blogger\BlogBundle\Form\CommentType;

/**
 * @Route("/comment")
 */
class CommentController extends Controller
{
  
  /**
   * Find blog post given blog id
   */
  public function getBlog($blogId)
  {
    $em = $this->getDoctrine()->getManager();

    $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($blogId);

    if(!$blog)
      {
        throw $this->createNotFoundException('Unable to find blog post.');
      }

    return $blog;
  }

  /**
   * Create a new blank comment form
   *
   * @Route("/{blogId}/new", requirements={"blogId" = "\d+"}, name="comment_new_for_blogid")
   * @Template("BloggerBlogBundle:Comment:form.html.twig")
   */
  public function newAction($blogId)
  {
    $blog = $this->getBlog($blogId);

    $comment = new Comment();
    $comment->setBlog($blog);

    $form = $this->createForm(new CommentType(), $comment);

    return array(
                 'comment' => $comment,
                 'form' => $form->createView(),
                 );
  }

  /**
   * Create the comment for a blog post after submission
   *
   * @Route("/{blogId}/create", requirements={"blogId" = "\d+"}, name="comment_create_for_blogid")
   * @Template()
   * @Method("POST")
   */
  public function createAction(Request $request, $blogId)
  {
    $blog = $this->getBlog($blogId);

    $comment = new Comment();
    $comment->setBlog($blog);

    $form = $this->createForm(new CommentType(), $comment);
    $form->bind($request);

    if($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return $this->redirect($this->generateUrl('blog_show_by_id_slug', array(
                                                                                'id' => $comment->getBlog()->getId(),
                                                                                'slug' => $comment->getBlog()->getSlug()))
                               . '#comment-' . $comment->getId()
                               );
      }

    return array(
                 'comment' => $comment,
                 'form' => $form->createView(),
                 );
  }
}
