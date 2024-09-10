<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\DataFixtures\AgentFixtures;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

class AgentApiControllerTest extends AbstractWebTestCase
{
    private const string BASE_URL = '/api/agents';

    public function testGet(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, self::BASE_URL);
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertCount(count(AgentFixtures::AGENTS), json_decode($response));
        $this->assertResponseBodySame([
            [
                'id' => '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566',
                'name' => 'Alessandro',
                'shortBio' => 'Desenvolvedor e evangelista de Software',
                'longBio' => 'Fomentador da comunidade de desenvolvimento, um dos fundadores da maior comunidade de PHP do Ceará (PHP com Rapadura)',
                'culture' => false,
                'organizations' => [
                    [],
                ],
                'createdAt' => '2024-07-10T11:30:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '84a5b3d1-a7a4-49a6-aff8-902a325f97f9',
                'name' => 'Henrique',
                'shortBio' => 'Desenvolvedor, pesquisador e evangelista cristão',
                'longBio' => 'Ativo na pesquisa de novas tecnologias.',
                'culture' => false,
                'organizations' => [
                    [],
                ],
                'createdAt' => '2024-07-11T10:49:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '0da862ef-0dc7-45c4-9bed-751ff379e9d3',
                'name' => 'Anna Kelly',
                'shortBio' => 'Desenvolvedora frontend e entusiasta de UX',
                'longBio' => 'Desenvolvedora frontend especializada em criar interfaces intuitivas e acessíveis. Entusiasta de UX e está sempre em busca de melhorias na experiência do usuário.',
                'culture' => false,
                'organizations' => [],
                'createdAt' => '2024-07-16T17:22:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'f07a3bd3-ce3a-4608-b2ae-6a22048630c2',
                'name' => 'Sara Jenifer',
                'shortBio' => 'Engenheira de software e defensora de código aberto',
                'longBio' => 'Sara Jenifer é uma engenheira de software com paixão por projetos de código aberto. Ela contribui regularmente para várias comunidades e promove a colaboração e o compartilhamento de conhecimento.',
                'culture' => false,
                'organizations' => [],
                'createdAt' => '2024-07-17T15:12:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '79cd7a39-2e48-4f09-b091-04cadf8e8a55',
                'name' => 'Talyson',
                'shortBio' => 'Desenvolvedor backend e especialista em segurança',
                'longBio' => 'Talyson é um desenvolvedor backend focado em construir sistemas robustos e seguros. Ele tem experiência em proteger aplicações contra vulnerabilidades e é conhecido por seu trabalho em segurança cibernética.',
                'culture' => false,
                'organizations' => [],
                'createdAt' => '2024-07-22T16:20:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'a9a9acc3-3cf5-4631-a29c-2cc31f9278e7',
                'name' => 'Raquel',
                'shortBio' => 'Produtora cultural e curadora de eventos',
                'longBio' => 'Atua há mais de 10 anos na produção de eventos culturais, promovendo a arte e a cultura local em diversas regiões do Brasil.',
                'culture' => true,
                'organizations' => [],
                'createdAt' => '2024-08-10T11:26:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'd250a8c9-b4f9-41e9-bb8a-e78606001439',
                'name' => 'Lucas',
                'shortBio' => 'Músico e produtor cultural',
                'longBio' => 'Especialista em música popular brasileira, trabalha na produção de álbuns e na organização de festivais de música no Nordeste.',
                'culture' => true,
                'organizations' => [],
                'createdAt' => '2024-08-11T15:54:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '12923f16-b744-41ad-bd45-ebf99a599801',
                'name' => 'Maria',
                'shortBio' => 'Pesquisadora e escritora',
                'longBio' => 'Dedica-se ao estudo das manifestações culturais nordestinas, com diversas publicações em revistas acadêmicas e participação em eventos internacionais.',
                'culture' => true,
                'organizations' => [],
                'createdAt' => '2024-08-12T14:24:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => '37a5640f-ca46-4612-9e53-a797f3b8f11c',
                'name' => 'Abner',
                'shortBio' => 'Cineasta e documentarista',
                'longBio' => 'Realiza documentários que retratam a cultura e as tradições do interior do Brasil, com destaque para o sertão nordestino.',
                'culture' => true,
                'organizations' => [],
                'createdAt' => '2024-08-13T20:25:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
            [
                'id' => 'd737554f-258e-4360-a653-177551f5b1a5',
                'name' => 'Paulo',
                'shortBio' => 'Formado em teológia pela UFC',
                'longBio' => 'Especializado em teológia, organiza exposições por todos o Ceará.',
                'culture' => true,
                'organizations' => [],
                'createdAt' => '2024-08-14T10:00:00+00:00',
                'updatedAt' => null,
                'deletedAt' => null,
            ],
        ]);
    }

    public function testGetItem(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_3);

        $client->request(Request::METHOD_GET, $url);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseBodySame([
            'id' => '0da862ef-0dc7-45c4-9bed-751ff379e9d3',
            'name' => 'Anna Kelly',
            'shortBio' => 'Desenvolvedora frontend e entusiasta de UX',
            'longBio' => 'Desenvolvedora frontend especializada em criar interfaces intuitivas e acessíveis. Entusiasta de UX e está sempre em busca de melhorias na experiência do usuário.',
            'culture' => false,
            'organizations' => [],
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ]);
    }

    public function testGetAResourceWhenNotFound(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, sprintf('%s/%s', self::BASE_URL, Uuid::v4()->toRfc4122()));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseBodySame([
            'error_message' => 'not_found',
            'error_details' => [
                'description' => 'The requested Agent was not found.',
            ],
        ]);
    }

    public function testDeleteAResourceWhenNotFound(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_DELETE, sprintf('%s/%s', self::BASE_URL, Uuid::v4()->toRfc4122()));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertResponseBodySame([
            'error_message' => 'not_found',
            'error_details' => [
                'description' => 'The requested Agent was not found.',
            ],
        ]);
    }

    public function testDeleteAnEventItemWithSuccess(): void
    {
        $client = static::createClient();

        $url = sprintf('%s/%s', self::BASE_URL, AgentFixtures::AGENT_ID_4);

        $client->request(Request::METHOD_DELETE, $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $client->request(Request::METHOD_GET, $url);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
