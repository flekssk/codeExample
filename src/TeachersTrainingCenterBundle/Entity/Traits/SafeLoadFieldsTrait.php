<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Entity\Traits;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Define property
 * protected $safeFields = ['questionAlias', 'periodId', 'userId', 'answerMark', 'answerComment', 'payload'];
 */
trait SafeLoadFieldsTrait
{
    /**
     * @var string[]
     */
    protected array $filledFields = [];

    public function loadFromRawJsonRequest(Request $request): void
    {
        $this->loadFromArray(json_decode($request->getContent(), true));
    }

    /**
     * @param array<string>|null $input
     */
    public function loadFromArray(?array $input): void
    {
        if (!is_array($input)) {
            return;
        }

        $this->filledFields = [];

        foreach ($this->safeFields as $field) {
            if (isset($input[$field])) {
                $this->{$field} = $this->loadRecursive($field, $input[$field]);
                $this->filledFields[] = $field;
            }
        }
    }

    public function loadFromRequest(Request $request): void
    {
        $this->loadFromBag($request->request);
    }

    public function loadFromAttributes(Request $request): void
    {
        $this->loadFromBag($request->attributes);
    }

    public function loadFromQuery(Request $request): void
    {
        $this->loadFromBag($request->query);
    }

    public function isFilled(string $field): bool
    {
        return in_array($field, $this->filledFields, true);
    }

    /**
     * @return string[]
     */
    public function getFilledFields(): array
    {
        return $this->filledFields;
    }

    /**
     * @return string[]
     */
    public function getSafeFields(): array
    {
        return $this->safeFields;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    private function loadRecursive(string $field, $data)
    {
        if (!isset($this->safeFieldsTypes[$field])) {
            return $data;
        }

        // Recursive load objects if they support this trait
        $class = $this->safeFieldsTypes[$field]['class'];

        $createAndLoadObject = static function ($className, $data) {
            $object = new $className();
            if (in_array(SafeLoadFieldsTrait::class, class_uses($className), true)) {
                $object->loadFromArray($data);

                return $object;
            }

            return null;
        };

        $createdObject = null;
        if ($this->safeFieldsTypes[$field]['type'] === 'array') {
            if (is_array($data)) {
                $createdObject = array_map(static fn ($item) => $createAndLoadObject($class, $item), $data);
            }
        } else {
            $createdObject = $createAndLoadObject($class, $data);
        }

        return $createdObject;
    }

    private function loadFromBag(ParameterBag $bag): void
    {
        $this->filledFields = [];

        foreach ($this->safeFields as $field) {
            if ($bag->has($field)) {
                $this->{$field} = $this->loadRecursive($field, $bag->get($field));
                $this->filledFields[] = $field;
            }
        }
    }
}
