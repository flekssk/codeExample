<?php

namespace TeachersTrainingCenterBundle\Controller\Api\User\TeacherStudent\v1\Output;

use TeachersTrainingCenterBundle\Entity\TeacherStudent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

final class GetTeacherStudentsResponse
{
    /**
     * @var array
     * @SWG\Property(type="array", @Model(type=GetTeacherStudentResponse::class))
     */
    public $items;

    /**
     * @param TeacherStudent[] $teacherStudents
     */
    public function __construct(array $teacherStudents)
    {
        $this->items = array_map(function (TeacherStudent $teacherStudent) {
            return new GetTeacherStudentResponse($teacherStudent);
        }, $teacherStudents);
    }
}
