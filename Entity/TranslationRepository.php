<?php

namespace Disjfa\TranslationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * TranslationRepository.
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class TranslationRepository extends EntityRepository
{
    /**
     * @param string $locale
     * @param string $domain
     * @param string $code
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    public function findOneByLocaleDomainAndCode(string $locale, string $domain, string $code)
    {
        return $this->createQueryBuilder('translation')
            ->where('translation.locale = :locale')
            ->andWhere('translation.domain = :domain')
            ->andWhere('translation.code = :code')
            ->setParameter('locale', $locale)
            ->setParameter('domain', $domain)
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $locale
     *
     * @return Translation[]|ArrayCollection
     */
    public function findByLocale(string $locale)
    {
        return $this->createQueryBuilder('translation')
            ->where('translation.locale = :locale')
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getResult();
    }
}
