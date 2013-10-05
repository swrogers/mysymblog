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

    /**
     * @Route("/contact", name="blogger_contact")
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
              return $this->redirect($this->generateUrl('blogger_contact'));
            }
        }
      
      return array(
                   'form' => $form->createView(),
                   );
    }
}
