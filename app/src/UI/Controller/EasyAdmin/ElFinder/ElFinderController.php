<?php

declare(strict_types=1);

namespace App\UI\Controller\EasyAdmin\ElFinder;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElFinderController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/admin/file-manager")
     */
    public function login(Request $request): Response
    {
        $params = [
            'locale' => 'ru',
            'fullscreen' => true,
            'instance' => 'default',
            'homeFolder' => '',
            'prefix' => '/public/bundles',
            'onlyMimes' => '[]',
            'theme' => 'smoothness',
            'pathPrefix' => '/',
        ];
        return $this->render('easy_admin_elfinder.html.twig', ['params' => $params]);
    }
}
