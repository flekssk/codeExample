<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Users\Input;

use Symfony\Component\HttpFoundation\Request;

class AttachCoursesRequest
{
    private $courseIds = [];

    public function loadFromRawJsonRequest(Request $request): void
    {
        $this->courseIds = json_decode($request->getContent(), true);
    }

    /**
     * @return array
     */
    public function getCourseIds(): array
    {
        return $this->courseIds;
    }
}
