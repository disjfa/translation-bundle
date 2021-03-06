<?php

namespace Disjfa\TranslationBundle\Menu;

use Disjfa\MenuBundle\Menu\ConfigureAdminMenu;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslationAdminMenuListener implements EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * HomeMenuListener constructor.
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function onMenuConfigure(ConfigureAdminMenu $event)
    {
        try {
            $menu = $event->getMenu();
            $menu->addChild('disjfa_translation', [
                'label' => $this->translator->trans('menu.translation', [], 'translation'),
                'route' => 'admin_translator_index',
            ])->setExtra('icon', 'fa-language');
        } catch (RouteNotFoundException $e) {
            // routing.yml not set up
            return;
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigureAdminMenu::class => ['onMenuConfigure', -100],
        ];
    }
}
