<?php

namespace Blogger\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Blogger\UserBundle\Entity\User;

class UserFixtures implements FixtureInterface, ContainerAwareInterface
{
  private $container;
  
  public function setContainer(ContainerInterface $container = null)
  {
    $this->container = $container;
  }

  public function load(ObjectManager $manager)
  {
    $userManager = $this->container->get('fos_user.user_manager');
    $securityManager = $this->container->get('security.encoder_factory');

    $user = $userManager->createUser();
    $encoder = $securityManager->getEncoder($user);

    $user->setUsername('swrogers');
    $user->setEmail('swrogers@gmail.com');
    $user->setEnabled(true);

    $password = $encoder->encodePassword('p@ssW0rd', $user->getSalt());
    $user->setPassword($password);
    $user->setFirstName('Shane');
    $user->setLastName('Rogers');

    $userManager->updateUser($user);
  }
}