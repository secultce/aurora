<?php
declare(strict_types=1);

namespace App\Service;

use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak as OAuth2Keycloak;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class KeyCloakService extends AbstractEntityService
{
    public function __construct(
        private Security $security
    )
    {
        parent::__construct($this->security);
    }

    protected function getTokenFull($urlServerKeyCloak, $token, $clientId, $clientSecret): Response
    {
        //http://172.19.18.235:8080
        $client = HttpClient::create();
        $endpointUser = $urlServerKeyCloak.'/realms/secultce/protocol/openid-connect/token/introspect';
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

    public function connectUsernamePass(string $authServerUrl, Request $request ) :AccessTokenInterface
    {
        $provider = new OAuth2Keycloak([
            'authServerUrl'         => $authServerUrl,
            'realm'                 => $request->server->get('IAM_REALM'),
            'clientId'              => $request->server->get('IAM_CLIENT_ID'),
            'clientSecret'          => $request->server->get('IAM_CLIENT_SECRET'),
            'redirectUri'           => $request->server->get('IAM_REDIRECT_URI'),
            'encryptionAlgorithm'   => $request->server->get('IAM_ENCRYPTION_ALGORITHM'),
            'version'               => $request->server->get('IAM_VERSION'),
        ]);

        return  $provider->getAccessToken('password', [
            'username' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ]);

    }

}
