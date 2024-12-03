<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak as OAuth2Keycloak;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\KeyCloakService;
use Symfony\Bundle\SecurityBundle\Security;

class KeyCloakWebController extends AbstractController
{
    public function __construct(
        private Security $security
    ) {
    }

    public function connect(Request $request): JsonResponse
    {
        dump($request);
        $keyCloakService = new KeycloakService($this->security);
        $accessToken = $keyCloakService->connectUsernamePass('http://172.19.18.235:8080/', $request);
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
        dump($accessToken); die;
        return '';

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

    #[ExcludeTokenValidationAttribute]
    public function authenKeycloak(Request $request): void
    {
        dump($request);

        $session = $request->getSession();
        $codeKey = $session->get('keycloak-code');
            $provider = new OAuth2Keycloak([
                'authServerUrl'         => 'http://172.19.18.235:8080',
                'realm'                 => $request->server->get('IAM_REALM'),
                'clientId'              => $request->server->get('IAM_CLIENT_ID'),
                'clientSecret'          => $request->server->get('IAM_CLIENT_SECRET'),
                'redirectUri'           => $request->server->get('IAM_REDIRECT_URI'),
                'encryptionAlgorithm'   => 'HS256',// optional
                'version'               => '26.0.5',
            ]);



        $token = $provider->getAccessToken('authorization_code', [
            'code' => $codeKey
        ]);
        dump($token);
//        $user = $provider->getResourceOwner($token);
//
//        // Use these details to create a new profile
//        printf('Hello %s!', $user->getName());
////        dump($decoded);
//        $decoded = JWT::decode($token->getToken(), new Key($request->server->get('IAM_CLIENT_SECRET'), 'RS256'));
//        dump($decoded);
        die;

    }

    public function getUserKeyCloak($token, $clientId, $clientSecret): Response
    {
        $client = HttpClient::create();
        $endpointUser = 'http://172.19.18.235:8080/realms/secultce/protocol/openid-connect/token/introspect';
        $res = $client->request('POST', $endpointUser, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'token' => $token,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ],
        ]);
        dump($res->toArray());die;

    }


}
