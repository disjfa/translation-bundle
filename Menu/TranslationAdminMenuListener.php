<?php

namespace Disjfa\TranslationBundle\Menu;

use App\Menu\ConfigureMenuEvent;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Translation\TranslatorInterface;

class TranslationAdminMenuListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * HomeMenuListener constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        try {
            $menu = $event->getMenu();
            $menu->addChild('disjfa_translation', [
                'label' => $this->translator->trans('menu.translation', [], 'admin'),
                'route' => 'admin_translator_index'
            ])->setExtra('icon', 'fa-language');
        } catch (RouteNotFoundException $e) {
            // routing.yml not set up
            return;
        }
    }
}
