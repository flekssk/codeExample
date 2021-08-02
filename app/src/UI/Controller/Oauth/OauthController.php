<?php

declare(strict_types=1);

namespace App\UI\Controller\Oauth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OauthController.
 *
 * @package App\UI\Controller\Oauth
 */
class OauthController extends AbstractController
{
    /**
     * @var string
     */
    private string $appCode;

    /**
     * @var string
     */
    private string $portalHost;

    /**
     * OauthController constructor.
     *
     * @param string $appCode
     * @param string $portalHost
     */
    public function __construct(string $appCode, string $portalHost)
    {
        $this->appCode = $appCode;
        $this->portalHost = $portalHost;
    }

    /**
     * @Route("/admin/oauth")
     * @param Request $request
     */
    public function oauth(Request $request): void
    {
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/login")
     */
    public function login(Request $request): Response
    {
        $url = $this->portalHost
            . '?client_id='
            . $this->appCode
            . '&redirect_uri='
            . $request->getSchemeAndHttpHost()
            . '/admin/oauth';
        return $this->render('login.html.twig', ['url' => $url]);
    }

    /**
     * @Route("/admin/logout")
     */
    public function logout(): void
    {
    }
}
