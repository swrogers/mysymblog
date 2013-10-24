<?php

namespace Blogger\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Blogger\UserBundle\Entity\User;


class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
  private $container;

  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }

  public function load(ObjectManager $manager)
  {
    $user = new User();
    $user->setUsername('shane');
    $user->setEmail('swrogers@gmail.com');
    $user->setSalt(md5(uniqid()));

    $encoder = $this->container
      ->get('security.encoder_factory')
      ->getEncoder($user)
      ;

    $user->setPassword($encoder->encodePassword('p@ssw0rd', $user->getSalt()));
    
    $manager->persist($user);
    $manager->flush();
  }
}