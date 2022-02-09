<?php

namespace TeachersTrainingCenterBundle\Controller\Api\User\TeacherStudent\v1\Output;

use TeachersTrainingCenterBundle\Entity\TeacherStudent;
use Swagger\Annotations as SWG;

final class GetTeacherStudentResponse
{
    /**
     * @var int
     * @SWG\Property(type="numeric", description="Student id")
     */
    public $id;

    /**
     * @var string|null
     * @SWG\Property(type="string", description="Avatar url")
     */
    public $avatarUrl;

    /**
     * @var string|null
     * @SWG\Property(type="string", description="Avatar url")
     */
    public $locale;

    /**
     * @var string
     * @SWG\Property(type="string", description="Student's name")
     */
    public $name;

    /**
     * @var string
     * @SWG\Property(type="string", description="Student's surname")
     */
    public $surname;

    /**
     * @var string
     * @SWG\Property(type="string", description="Student's timezone")
     */
    public $timezone;

    public function __construct(TeacherStudent $teacherStudent)
    {
        $this->id = $teacherStudent->getStudent()->getId();
        $this->avatarUrl = $teacherStudent->getStudent()->getAvatarUrl();
        $this->locale = $teacherStudent->getStudent()->getLocale();
        $this->name = $teacherStudent->getStudent()->getName();
        $this->surname = $teacherStudent->getStudent()->getSurname();
        $this->timezone = $teacherStudent->getStudent()->getTimezone();
    }
}
