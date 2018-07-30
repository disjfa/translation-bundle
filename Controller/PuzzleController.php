<?php

namespace Disjfa\TranslationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/translation")
 */
class TranslationController extends Controller
{
    /**
     * @Route("/", name="disjfa_mozaic_puzzle_index")
     */
    public function indexAction()
    {
        return $this->render('@DisjfaTranslation/Translation/index.html.twig', [
        ]);
    }
}
