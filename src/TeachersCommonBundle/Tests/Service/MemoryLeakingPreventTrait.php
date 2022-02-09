<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Tests\Service;

use ReflectionObject;

trait MemoryLeakingPreventTrait
{
    /**
     * Предотвращение утечек памяти для функциональных тестов
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $reflection = new ReflectionObject($this);

        foreach ($reflection->getProperties() as $prop) {
            if ($prop->isPrivate()) {
                echo \sprintf(
                    'Set property %s protected or public for prevent memory leaking' . \PHP_EOL,
                    $prop->getName()
                );
            }

            if ($this->canBeUnset($prop)) {
                $prop->setAccessible(true);
                $propsName = $prop->getName();
                unset($this->$propsName);
            }
        }

        \gc_collect_cycles();
    }

    private function canBeUnset(\ReflectionProperty $prop): bool
    {
        return !$prop->isStatic() && strpos($prop->getDeclaringClass()->getName(), 'PHPUnit') && !$prop->isPrivate();
    }
}
