<?php

namespace App\Infrastructure\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class EasyAdminSkillEventSubscriber.
 *
 * @package App\Infrastructure\EventSubscriber
 */
class EasyAdminSkillEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * EasyAdminSkillEventSubscriber constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EasyAdminEvents::PRE_EDIT => ['onPreEdit'],
        ];
    }

    /**
     * При загрузке страницы редактирования навыка необходимо что бы request был параметр skill.
     * Если его не будет - пустая форма со ссылками навыков не сохранится.
     * Такое может произойти если у навыка не должно быть ссылок.
     *
     * @param GenericEvent $event
     */
    public function onPreEdit(GenericEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return;
        }

        $entity = $request->query->get('entity');
        if ($entity !== 'Skill') {
            return;
        }

        if (!$request->request->has('skill')) {
            $request->request->add(
                [
                    'skill' => ['skillImproveLinks' => null],
                ]
            );
        }
    }
}
