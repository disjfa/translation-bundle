<?php

namespace Disjfa\TranslationBundle\Controller;

use Disjfa\TranslationBundle\Entity\Translation;
use Disjfa\TranslationBundle\Form\Type\TranslationType;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/translation")
 */
class TranslationController extends Controller
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * TranslatorController constructor.
     * @param TranslatorInterface $translator
     * @param AdapterInterface $cache
     */
    public function __construct(TranslatorInterface $translator, AdapterInterface $cache)
    {
        /** @var Translator $translator */
        $this->translator = $translator;
        $this->cache = $cache;
    }

    /**
     * @Route("", name="admin_translator_index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $result = [];

        $domains = $this->translator->getCatalogue()->getDomains();

        $requestDomain = $request->query->get('domain');
        $search = $request->query->get('search');
        if ($requestDomain && in_array($requestDomain, $domains)) {
            $currentDomains = [$requestDomain];
        } else {
            $currentDomains = $domains;
        }

        foreach ($currentDomains as $domain) {
            foreach ($this->translator->getCatalogue()->all($domain) as $code => $text) {
                if ($search && false === stripos($code, $search) && false === stripos($text , $search)) {
                    continue;
                }
                $result[] = [
                    'domain' => $domain,
                    'code' => $code,
                    'text' => $text,
                ];
            }
        };

        return $this->render('@DisjfaTranslation/Translation/index.html.twig', [
            'domains' => $domains,
            'requestDomain' => $requestDomain,
            'search' => $search,
            'result' => $this->get('knp_paginator')->paginate($result, $request->query->getInt('page', 1)),
            'locale' => $this->translator->getLocale(),
        ]);
    }

    /**
     * @Route("/edit/{locale}/{domain}/{code}", name="admin_translator_edit")
     * @param Request $request
     * @param string $locale
     * @param string $domain
     * @param string $code
     * @return Response
     * @throws NonUniqueResultException
     * @throws InvalidArgumentException
     */
    public function edit(Request $request, string $locale, string $domain, string $code)
    {
        $translation = $this->getDoctrine()->getRepository(Translation::class)->findOneByLocaleDomainAndCode($locale, $domain, $code);
        if (null === $translation) {
            $text = $this->translator->getCatalogue($locale)->get($code, $domain);
            $translation = new Translation($locale, $domain, $code, $text);
        }
        $form = $this->createForm(TranslationType::class, $translation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($translation);
            $em->flush();

            $this->cache->deleteItem('translations.' . $locale);

            $this->addFlash('success', $this->translator->trans('flash.translation_saved', [], 'translation'));
            return $this->redirectToRoute('admin_translator_index');
        }


        return $this->render('@DisjfaTranslation/Translation/form.html.twig', [
            'form' => $form->createView(),
            'translation' => $translation,
        ]);
    }
}