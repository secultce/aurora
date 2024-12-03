<?php
declare(strict_types=1);

namespace App\Service;

use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak as OAuth2Keycloak;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

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
        $client = new Client(['base_uri' => $authServerUrl]);
        $this->makeRequest($client, '/realms/secultce/protocol/openid-connect/auth');

        die;
        $provider = new OAuth2Keycloak([
            'authServerUrl'         => $authServerUrl,
            'realm'                 => $request->server->get('IAM_REALM'),
            'clientId'              => $request->server->get('IAM_CLIENT_ID'),
            'clientSecret'          => $request->server->get('IAM_CLIENT_SECRET'),
            'redirectUri'           => $request->server->get('IAM_REDIRECT_URI'),
            'encryptionAlgorithm'   => $request->server->get('IAM_ENCRYPTION_ALGORITHM'),
            'version'               => $request->server->get('IAM_VERSION'),
        ]);

        try {
            dump($provider);
            dump($provider->getHttpClient());

//            return  $provider->getAccessToken('password', [
//                'username' => $request->request->get('email'),
//                'password' => $request->request->get('password'),
//            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
        die;
    }

    public function makeRequest(Client $client, string $url) : JsonResponse
    {
        try {
            $response = $client->get($url);
            $statusCode = $response->getStatusCode();

            // Verifica se a resposta foi bem-sucedida
            if ($statusCode >= 200 && $statusCode < 300) {
                return $response->getBody()->getContents(); // Retorna o conteúdo da resposta
            } else {
                throw new Exception("Erro HTTP: Status code $statusCode");
            }
        } catch (ConnectException $e) {
            // Erro de conexão, como DNS ou timeout
            $status =  new JsonResponse(['message' => 'Erro de Conexão com a url ']);
            return $status->getContent();
//            return $this->json($user, status: Response::HTTP_CREATED, context: ['groups' => 'user.get']);
        } catch (RequestException $e) {
            // Erro relacionado à requisição (HTTP), podemos pegar o status code
            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                return "Erro HTTP: Status code $statusCode - " . $e->getMessage();
            } else {
                return "Erro na requisição: " . $e->getMessage();
            }
        } catch (Exception $e) {
            // Qualquer outro erro inesperado
            return "Erro inesperado: " . $e->getMessage();
        }
    }


}
