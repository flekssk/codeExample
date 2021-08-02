<?php

namespace App\UI\Controller\EasyAdmin;

use App\Application\Cache\CacheServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class CacheController.
 *
 * @package App\UI\Controller\EasyAdmin
 */
class CacheController extends AbstractController
{
    /**
     * @var CacheServiceInterface
     */
    private CacheServiceInterface $cacheService;

    public function __construct(
        CacheServiceInterface $cacheService
    ) {
        $this->cacheService = $cacheService;
    }
    /**
     * @Route("/admin/cache")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $type = $request->get('type') ?? '';
        if ($type === 'clear') {
            $this->cacheService->clear();
        }
        return $this->render('cache.html.twig', ['console' => $this->cacheService->info()]);
    }
}
