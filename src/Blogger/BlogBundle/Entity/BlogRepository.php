<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends EntityRepository
{
  /**
   * Returns all blog posts ordered by 
   * date. If a limit is provided then
   * only returns that amount
   */
  public function getLatestBlogs($limit = null)
  {
    $qb = $this->createQueryBuilder('b')
      ->select('b')
      ->addOrderBy('b.created', 'DESC');

    if(false === is_null($limit))
      {
        $qb->setMaxResults($limit);
      }

    return $qb->getQuery()->getResult();
  }
}
