<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sendio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

/**
 * @Route("/")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="page_index")
     * @Template()
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();

      $blogs = $em->getRepository('BloggerBlogBundle:Blog')
        ->getLatestBlogs();

      return array(
                   'blogs' => $blogs,
                   );
    }

    /**
     * @Route("/about", name="page_about")
     * @Template()
     */
    public function aboutAction()
    {
      return array(
                   'imahack' => 'isahack',
                   );
    }

    /**
     * @Route("/contact", name="page_contact")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $request)
    {
      $enquiry = new Enquiry();
      $form = $this->createForm(new EnquiryType(), $enquiry);
      
      if($request->getMethod() == 'POST')
        {
          $form->bind($request);
          
          if($form->isValid())
            {
              $message = \Swift_Message::newInstance()
                ->setSubject('Contact enquiry from symblog')
                ->setFrom('knytphal@gmail.com')
                ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));

              $this->get('mailer')->send($message);

              $this->get('session')->getFlashBag()->add('blogger-notice','Your contact enquiry was successfully sent. Thank you!');

              return $this->redirect($this->generateUrl('blogger_contact'));
            }
        }
      
      return array(
                   'form' => $form->createView(),
                   );
    }

    /**
     * Handle the sidebar duties
     * @Route("/sidebar", name="page_sidebar")
     * @Template()
     */
    public function sidebarAction()
    {
      $em = $this->getDoctrine()->getManager();
      
      $tags = $em->getRepository('BloggerBlogBundle:Blog')
        ->getTags();

      $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
        ->getTagWeights($tags);

      $commentLimit = $this->container->getParameter('blogger_blog.comments.latest_comment_limit');
      $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
        ->getLatestComments($commentLimit);

      return array(
                   'tags' => $tagWeights,
                   'latestComments' => $latestComments,
                   );
    }
}
