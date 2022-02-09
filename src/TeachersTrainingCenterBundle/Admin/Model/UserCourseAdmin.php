<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Admin\Model;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use TeachersTrainingCenterBundle\Api\ContentApi\ContentApi;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Entity\UserCourse;

class UserCourseAdmin extends AbstractAdmin
{

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingAnyTypeHint
     */
    protected $baseRouteName = 'admin_app_usercourse';

    /**
     * @var string[]|null
     */
    private array $courseMap;

    private ?ContentApi $contentApi;

    public function __construct(
        string $code,
        string $class,
        ?string $baseControllerName = null,
        ?ContentApi $contentApi = null
    ) {
        parent::__construct($code, $class, $baseControllerName);

        $this->contentApi = $contentApi;
        $this->courseMap = [];
    }

    /**
     * @return string[]|null
     */
    public function getCourseMap(): ?array
    {
        if (!$this->courseMap) {
            $this->courseMap = $this->contentApi->getCourseMap();
        }

        return $this->courseMap;
    }

    public function getCourseName(UserCourse $userCourse): string
    {
        return $this->courseMap[$userCourse->getCourseId()] ?? 'Unknown course';
    }

    /**
     * @return string[]
     */
    public function getExportFormats(): array
    {
        return ['csv', 'json'];
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('userId', IntegerType::class);
        $form->add('courseId', IntegerType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('userId');
        $filter->add('courseId');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id', null, [
            'header_style' => 'width: 10%; text-align: center',
            'row_align' => 'center',
        ]);
        $list->add('userId', null, [
            'header_style' => 'width: 10%; text-align: center',
            'row_align' => 'center',
        ]);
        $list->add('courseId', null, [
            'header_style' => 'width: 10%; text-align: center',
            'row_align' => 'center',
        ]);
        $list->add('courseName', null, [
            'header_style' => 'width: 10%; text-align: center',
            'row_align' => 'center',
        ]);
        $list->add('', null, [
            'header_style' => 'width: 70%; text-align: center',
            'row_align' => 'center',
        ]);
    }

    protected function configureRoutes(RouteCollection $collection): void
    {
        $collection->add('showBatchAddForm');
        $collection->add('batchAdd');

        $collection->add('showBatchDeleteForm');
        $collection->add('batchDelete');

        $collection->add('csvImport');
        $collection->add('csvDelete');
    }
}
