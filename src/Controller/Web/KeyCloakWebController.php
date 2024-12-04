<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak as OAuth2Keycloak;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\KeyCloakService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class KeyCloakWebController extends AbstractController
{
    public function __construct(
        private Security $security,
        protected TokenStorageInterface $tokenStorage,
    ) {
    }

    public function connect(Request $request, UserRepository $userRepository)
    {
//        dump($request);
        $keyCloakService = new KeycloakService($this->security);
        $accessToken = $keyCloakService->connectUsernamePass('http://192.168.30.121:8080/', $request);
//        dump($accessToken);
        //Token completo do keycloak
        $tokenUserKeyCloak = $this->getUserKeyCloak($accessToken, $request);
        $credentials = $tokenUserKeyCloak->toArray();
//        dump($credentials['email']);
        // Buscando usuário no banco
        $user = $userRepository->findByEmail($credentials['email']);
//        dump($user);
        // Autenticação
        $token = new UsernamePasswordToken($user, 'web');
//        dump($token->getUser());
//
        $this->tokenStorage->setToken($token);
        $auth = $this->security->getUser();
        dump($auth->getUserIdentifier());
        dump($auth->getRoles());die;
        // Gerando Sessão do usuário

        return $this->redirectToRoute('web_home_homepage');
//        $this->get('security.token_storage')->setToken($token);
//        $this->get('session')->set('_security_main', serialize($token));
//        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
//        $this->get('security.token_storage')->setToken($token);
//        $this->get('session')->set('_security_main', serialize($token));

//        if($accessToken['status'] >= 400)
//        {
//
//            return $this->redirect('http://localhost:8082/login');
//
//        }
//        $provider = new OAuth2Keycloak([
//            'authServerUrl'         => 'http://172.19.18.235:8080/',
//            'realm'                 => $request->server->get('IAM_REALM'),
//            'clientId'              => $request->server->get('IAM_CLIENT_ID'),
//            'clientSecret'          => $request->server->get('IAM_CLIENT_SECRET'),
//            'redirectUri'           => $request->server->get('IAM_REDIRECT_URI'),
//            'encryptionAlgorithm'   => $request->server->get('IAM_ENCRYPTION_ALGORITHM'),
//            'version'               => $request->server->get('IAM_VERSION'),
//        ]);
//
//        $accessToken =  $provider->getAccessToken('password', [
//            'username' => $request->request->get('email'),
//            'password' => $request->request->get('password'),
//        ]);

        // We got an access token, let's now get the user's details
//        $user = $provider->getAuthenticatedRequest();

        // Use these details to create a new profile
//        return $this->json($agent, context: ['groups' => ['agent.get', 'agent.get.item']]);


//        $keycloak = new KeycloakController($this->keycloakClientLogger, $this->iamClient);
//        return $keycloak->connect($request);
    }

    public function connectCheck(Request $request): Response
    {
        $defaultTargetRouteName = $request->server->get('TARGET_ROUTE_NAME');
        $loginReferrer = null;

        $session = new Session();
        if ($request->hasSession()) {
            $session->set('keycloak-code', $request->query->get('code'));

            $loginReferrer = $request->getSession()->remove(KeycloakAuthorizationCodeEnum::LOGIN_REFERRER);
        }

        $this->keycloakClientLogger->info('KeycloakController::connectCheck', [
            'defaultTargetRouteName' => $defaultTargetRouteName,
            'loginReferrer' => $loginReferrer,
        ]);
        return $loginReferrer ? $this->redirect($loginReferrer) : $this->redirectToRoute($defaultTargetRouteName);
    }

    public function getUserKeyCloak($token, $request): ResponseInterface
    {
        $client = HttpClient::create();
        $endpointUser = 'http://192.168.30.121:8080/realms/secultce/protocol/openid-connect/token/introspect';
        return $client->request('POST', $endpointUser, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'token' => $token->getToken(),
                'client_id' => $request->server->get('IAM_CLIENT_ID'),
                'client_secret' => $request->server->get('IAM_CLIENT_SECRET'),
            ],
        ]);
    }


}
