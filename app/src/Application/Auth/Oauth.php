<?php

declare(strict_types=1);

namespace App\Application\Auth;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;

/**
 * Class Oauth.
 *
 * @package App\Application\Auth
 */
class Oauth extends AbstractGuardAuthenticator implements AuthenticatorInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var Client
     */
    private Client $guzzleClient;

    /**
     * @var string
     */
    private string $appCode;

    /**
     * @var string
     */
    private string $clientCode;

    /**
     * Oauth constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string $appCode
     * @param string $portalHost
     */
    public function __construct(EntityManagerInterface $entityManager, string $appCode, string $clientCode)
    {
        $this->em = $entityManager;
        $this->guzzleClient = new Client();
        $this->appCode = $appCode;
        $this->clientCode = $clientCode;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->getPathInfo() === '/admin/oauth' && $request->isMethod('GET');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCredentials(Request $request)
    {
        $code = $request->get('code');

        $oauthDomainUrl = 'https://' . $request->get('server_domain') . '/oauth/token/';
        $userInfoDomainUrl = 'https://' . $request->get('domain') . '/ext-rest/user.extended.info.json';

        $authData = $this->authUserByCode($oauthDomainUrl, $code);

        return $this->getUserInfo($userInfoDomainUrl, $authData);
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return User
     * @throws \Exception
     */
    public function getUser($credentials, UserProviderInterface $userProvider): User
    {
        /** @var User $user */
        $user = $this->em
            ->getRepository(User::class)
            ->findOneBy(['uuid' => $credentials->id]);

        if (!$user) {
            $user = new User();
            $user->setUuid($credentials->id);
            $user->setName($credentials->name);
            $user->setEmail($credentials->email);

            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse('/admin/login');
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return (empty($credentials->id) ? false : true);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response|void|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse('/admin/');
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param $url
     * @param $code
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function authUserByCode($url, $code)
    {
        $response = $this->guzzleClient->request('GET', $url, [
            'query' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'client_id' => $this->appCode,
                'client_secret' => $this->clientCode,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $url
     * @param $authData
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getUserInfo($url, $authData)
    {
        $response = $this->guzzleClient->request('POST', $url, [
            'form_params' => [
                'access_token' => $authData->access_token,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
