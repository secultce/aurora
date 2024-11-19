<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Agent;
use App\Entity\User;
use App\Service\Interface\FileServiceInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class AgentFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const string AGENT_ID_PREFIX = 'agent';
    public const string AGENT_ID_1 = '0cc8c682-b0cd-4cb3-bd9d-41a9161b3566';
    public const string AGENT_ID_2 = '84a5b3d1-a7a4-49a6-aff8-902a325f97f9';
    public const string AGENT_ID_3 = '0da862ef-0dc7-45c4-9bed-751ff379e9d3';
    public const string AGENT_ID_4 = 'f07a3bd3-ce3a-4608-b2ae-6a22048630c2';
    public const string AGENT_ID_5 = '79cd7a39-2e48-4f09-b091-04cadf8e8a55';
    public const string AGENT_ID_6 = 'a9a9acc3-3cf5-4631-a29c-2cc31f9278e7';
    public const string AGENT_ID_7 = 'd250a8c9-b4f9-41e9-bb8a-e78606001439';
    public const string AGENT_ID_8 = '12923f16-b744-41ad-bd45-ebf99a599801';
    public const string AGENT_ID_9 = '37a5640f-ca46-4612-9e53-a797f3b8f11c';
    public const string AGENT_ID_10 = 'd737554f-258e-4360-a653-177551f5b1a5';

    public const array AGENTS = [
        [
            'id' => self::AGENT_ID_1,
            'name' => 'Feitoza',
            'image' => null,
            'shortBio' => 'Desenvolvedor e evangelista de Software',
            'longBio' => 'Fomentador da comunidade de desenvolvimento, um dos fundadores da maior comunidade de PHP do Ceará (PHP com Rapadura)',
            'culture' => false,
            'extraFields' => [
                'email' => 'alessandro@example.com',
                'instagram' => '@alessandro',
            ],
            'user' => UserFixtures::USER_ID_1,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_2,
            'name' => 'Henrique',
            'image' => null,
            'shortBio' => 'Desenvolvedor, pesquisador e evangelista cristão',
            'longBio' => 'Ativo na pesquisa de novas tecnologias.',
            'culture' => false,
            'extraFields' => [
                'email' => 'henrique@example.com',
                'instagram' => '@henrique',
            ],
            'user' => UserFixtures::USER_ID_2,
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_3,
            'name' => 'Anna Kelly',
            'image' => null,
            'shortBio' => 'Desenvolvedora frontend e entusiasta de UX',
            'longBio' => 'Desenvolvedora frontend especializada em criar interfaces intuitivas e acessíveis. Entusiasta de UX e está sempre em busca de melhorias na experiência do usuário.',
            'culture' => false,
            'extraFields' => [
                'email' => 'anna@example.com',
                'instagram' => '@anna',
            ],
            'user' => UserFixtures::USER_ID_3,
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_4,
            'name' => 'Sara Jennifer',
            'image' => null,
            'shortBio' => 'Engenheira de software e defensora de código aberto',
            'longBio' => 'Sara Jenifer é uma engenheira de software com paixão por projetos de código aberto. Ela contribui regularmente para várias comunidades e promove a colaboração e o compartilhamento de conhecimento.',
            'culture' => false,
            'extraFields' => [
                'email' => 'sara@example.com',
                'instagram' => '@sara',
            ],
            'user' => UserFixtures::USER_ID_4,
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_5,
            'name' => 'Talyson',
            'image' => null,
            'shortBio' => 'Desenvolvedor backend e especialista em segurança',
            'longBio' => 'Talyson é um desenvolvedor backend focado em construir sistemas robustos e seguros. Ele tem experiência em proteger aplicações contra vulnerabilidades e é conhecido por seu trabalho em segurança cibernética.',
            'culture' => false,
            'extraFields' => [
                'email' => 'talyson@example.com',
                'instagram' => '@talyson',
            ],
            'user' => UserFixtures::USER_ID_5,
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_6,
            'name' => 'Raquel',
            'image' => null,
            'shortBio' => 'Produtora cultural e curadora de eventos',
            'longBio' => 'Atua há mais de 10 anos na produção de eventos culturais, promovendo a arte e a cultura local em diversas regiões do Brasil.',
            'culture' => true,
            'extraFields' => [
                'email' => 'raquel@example.com',
                'instagram' => '@raquel',
            ],
            'user' => UserFixtures::USER_ID_6,
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_7,
            'name' => 'Lucas',
            'image' => null,
            'shortBio' => 'Músico e produtor cultural',
            'longBio' => 'Especialista em música popular brasileira, trabalha na produção de álbuns e na organização de festivais de música no Nordeste.',
            'culture' => true,
            'extraFields' => [
                'email' => 'lucas@example.com',
                'instagram' => '@lucas',
            ],
            'user' => UserFixtures::USER_ID_7,
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_8,
            'name' => 'Maria',
            'image' => null,
            'shortBio' => 'Pesquisadora e escritora',
            'longBio' => 'Dedica-se ao estudo das manifestações culturais nordestinas, com diversas publicações em revistas acadêmicas e participação em eventos internacionais.',
            'culture' => true,
            'extraFields' => [
                'email' => 'maria@example.com',
                'instagram' => '@maria',
            ],
            'user' => UserFixtures::USER_ID_8,
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_9,
            'name' => 'Abner',
            'image' => null,
            'shortBio' => 'Cineasta e documentarista',
            'longBio' => 'Realiza documentários que retratam a cultura e as tradições do interior do Brasil, com destaque para o sertão nordestino.',
            'culture' => true,
            'extraFields' => [
                'email' => 'abner@example.com',
                'instagram' => '@abner',
            ],
            'user' => UserFixtures::USER_ID_9,
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::AGENT_ID_10,
            'name' => 'Paulo',
            'image' => null,
            'shortBio' => 'Formado em teológia pela UFC',
            'longBio' => 'Especializado em teológia, organiza exposições por todos o Ceará.',
            'culture' => true,
            'extraFields' => [
                'email' => 'paulo@example.com',
                'instagram' => '@paulo',
            ],
            'user' => UserFixtures::USER_ID_10,
            'createdAt' => '2024-08-14T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public const array AGENTS_UPDATED = [
        [
            'id' => self::AGENT_ID_1,
            'name' => 'Alessandro',
            'image' => null,
            'shortBio' => 'Desenvolvedor e evangelista de Software',
            'longBio' => 'Fomentador da comunidade de desenvolvimento, um dos fundadores da maior comunidade de PHP do Ceará (PHP com Rapadura)',
            'culture' => false,
            'extraFields' => [
                'email' => 'alessandro@example.com',
                'instagram' => '@alessandro',
            ],
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => '2024-07-10T11:37:00+00:00',
            'deletedAt' => null,
        ],
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
        private readonly FileServiceInterface $fileService,
        private readonly ParameterBagInterface $parameterBag,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->truncateTable(Agent::class);
        $this->createAgents($manager);
        $this->updateAgents($manager);
        $this->manualLogout();
    }

    private function createAgents(ObjectManager $manager): void
    {
        $counter = 0;

        foreach (self::AGENTS as $agentData) {
            if (5 > $counter) {
                $file = $this->fileService->uploadImage($this->parameterBag->get('app.dir.agent.profile'), ImageTestFixtures::getAgentImage());
                $agentData['image'] = $file;
            }

            /** @var Agent $agent */
            $agent = $this->serializer->denormalize($agentData, Agent::class);

            /** @var User $user */
            $user = $this->getReference(sprintf('%s-%s', UserFixtures::USER_ID_PREFIX, $agentData['user']));
            $agent->setUser($user);

            $this->manualLogin($user->getId()->toRfc4122());

            $this->setReference(sprintf('%s-%s', self::AGENT_ID_PREFIX, $agentData['id']), $agent);

            $manager->persist($agent);
            $counter++;
        }

        $manager->flush();
    }

    private function updateAgents(ObjectManager $manager): void
    {
        foreach (self::AGENTS_UPDATED as $agentData) {
            unset($agentData['image']);

            $agentObj = $this->getReference(sprintf('%s-%s', self::AGENT_ID_PREFIX, $agentData['id']), Agent::class);

            /** @var Agent $agent */
            $agent = $this->serializer->denormalize($agentData, Agent::class, context: ['object_to_populate' => $agentObj]);

            $this->manualLogin($agent->getUser()->getId()->toRfc4122());

            $manager->persist($agent);
        }

        $manager->flush();
    }
}
