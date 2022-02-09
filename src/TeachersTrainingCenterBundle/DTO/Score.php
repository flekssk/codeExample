<?php

namespace TeachersTrainingCenterBundle\DTO;

class Score
{
    /**
     * @var int
     */
    public $score = 0;

    /**
     * @var int
     */
    public $completeness = 0;

    public static function fromArray(array $array): Score
    {
        $score = new static();
        $score->score = $array['score'];
        $score->completeness = $array['completeness'];

        return $score;
    }

    public function toArray(): array
    {
        return ['score' => $this->score, 'completeness' => $this->completeness];
    }

    public function equals(Score $anotherScore): bool
    {
        return $this->score === $anotherScore->score && $this->completeness === $anotherScore->completeness;
    }
}
