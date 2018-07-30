<?php

namespace Disjfa\TranslationBundle\EventListener;

use Disjfa\TranslationBundle\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @var AdapterInterface
     */
    protected $cache;

    /**
     * RequestListener constructor.
     * @param TranslatorInterface $translator
     * @param EntityManagerInterface $entityManager
     * @param AdapterInterface $cache
     */
    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager, AdapterInterface $cache)
    {
        /** @var Translator $translator */
        $this->translator = $translator;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
    }

    /**
     * @param GetResponseEvent $event
     * @throws InvalidArgumentException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $catalogue = $this->translator->getCatalogue();
        $locale = $this->translator->getLocale();

        $translationCache = $this->cache->getItem('translations.' . $locale);
        if (false === $translationCache->isHit()) {
            $translations = $this->entityManager->getRepository(Translation::class)->findByLocale($locale);

            $dbMessages = array();
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