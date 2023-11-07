<?php

namespace Disjfa\TranslationBundle\EventListener;

use Disjfa\TranslationBundle\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslationListener
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var CacheItemPoolInterface
     */
    protected $cache;

    /**
     * RequestListener constructor.
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager, CacheItemPoolInterface $cache)
    {
        /* @var Translator $translator */
        $this->translator = $translator;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if ( ! $event->isMainRequest()) {
            return;
        }

        $catalogue = $this->translator->getCatalogue();
        $locale = $this->translator->getLocale();

        $translationCache = $this->cache->getItem('translations.'.$locale);
        if (false === $translationCache->isHit()) {
            $translations = $this->entityManager->getRepository(Translation::class)->findByLocale($locale);

            $dbMessages = [];
            foreach ($translations as $translation) {
                $dbMessages[$translation->getDomain()][$translation->getCode()] = $translation->getText();
            }

            $translationCache->set($dbMessages);
            $translationCache->expiresAfter(3600);
            $this->cache->save($translationCache);
        } else {
            $dbMessages = $translationCache->get();
        }

        foreach (array_keys($dbMessages) as $domain) {
            $catalogue->add($dbMessages[$domain], $domain);
        }
    }
}
