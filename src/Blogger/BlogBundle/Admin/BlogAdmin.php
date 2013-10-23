<?php

namespace Blogger\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogAdmin extends Admin
{
  /**
   * Fields to be shown on create and edit forms
   */
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('title', 'text', array('label' => 'Post Title'))
      ->add('author', 'text')
      ->add('blog')
      ->add('image', 'text', array('label' => 'File name on server'))
      ->add('tags', 'text', array('label' => 'Comma seperated list'))
      ;
  }

  /**
   * Fields to be shown on filter forms
   */
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('title')
      ->add('author')
      ;
  }

  /**
   * Fields to be shown on lists
   */
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->addIdentifier('title')
      ->add('slug')
      ->add('author')
      ;
  }
  
}