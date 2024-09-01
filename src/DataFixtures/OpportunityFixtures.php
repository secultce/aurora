<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Opportunity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

final class OpportunityFixtures extends Fixture implements DependentFixtureInterface
{
    public const OPPORTUNITY_ID_PREFIX = 'opportunity';
    public const OPPORTUNITY_ID_1 = '2f31c3b5-4385-4f1d-afc5-6042875a168e';
    public const OPPORTUNITY_ID_2 = '39994097-41d8-463c-a7eb-7d9a0b40e953';
    public const OPPORTUNITY_ID_3 = 'd9de9ad1-0a4b-4e4f-a3bb-5d61b9291339';
    public const OPPORTUNITY_ID_4 = '378cc989-c2ae-4118-9f19-54bacb8718c4';
    public const OPPORTUNITY_ID_5 = 'd1068a81-c006-4358-8846-a95ef252c881';
    public const OPPORTUNITY_ID_6 = '45b263fa-952f-4e24-ad89-e715c08ab87e';
    public const OPPORTUNITY_ID_7 = 'f8e0d2bb-a4d7-48e9-914b-85c563b6dd56';
    public const OPPORTUNITY_ID_8 = '18db4f50-ff61-4cee-aedb-7bcee0908537';
    public const OPPORTUNITY_ID_9 = 'ee2a9645-58a6-44d0-bf31-a908a9d1814d';
    public const OPPORTUNITY_ID_10 = '083ef392-4c63-4200-a57f-818a1a75211c';

    public const OPPORTUNITIES = [
        [
            'id' => self::OPPORTUNITY_ID_1,
            'name' => 'Inscrição para o Concurso de Cordelistas - Festival de Literatura Nordestina',
            'description' => 'Aberto edital para inscrições no concurso de cordelistas que ocorrerá durante o Festival de Literatura Nordestina.',
            'createdBy' => AgentFixtures::AGENT_ID_1,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_1,
            'project' => InitiativeFixtures::INITIATIVE_ID_1,
            'event' => EventFixtures::EVENT_ID_1,
            'createdAt' => '2024-09-06T10:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_2,
            'name' => 'Chamada para Oficinas de Artesanato - Feira de Cultura Popular',
            'description' => 'Estão abertas as inscrições para artesãos que desejam ministrar oficinas na Feira de Cultura Popular.',
            'createdBy' => AgentFixtures::AGENT_ID_2,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_2,
            'project' => InitiativeFixtures::INITIATIVE_ID_2,
            'event' => EventFixtures::EVENT_ID_2,
            'createdAt' => '2024-09-07T11:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_3,
            'name' => 'Credenciamento de Quadrilhas Juninas - São João do Nordeste',
            'description' => 'Edital de credenciamento para quadrilhas juninas interessadas em participar do São João do Nordeste.',
            'createdBy' => AgentFixtures::AGENT_ID_3,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_3,
            'project' => InitiativeFixtures::INITIATIVE_ID_3,
            'event' => EventFixtures::EVENT_ID_3,
            'createdAt' => '2024-09-08T12:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_4,
            'name' => 'Inscrição para o Festival de Danças Folclóricas - Encontro Nordestino',
            'description' => 'Concurso de danças folclóricas aberto para inscrições, integrando o Encontro Nordestino de Cultura.',
            'createdBy' => AgentFixtures::AGENT_ID_4,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_4,
            'project' => InitiativeFixtures::INITIATIVE_ID_4,
            'event' => EventFixtures::EVENT_ID_4,
            'createdAt' => '2024-09-09T13:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_5,
            'name' => 'Edital de Patrocínio para Grupos de Maracatu - Carnaval Cultural',
            'description' => 'Oportunidade de patrocínio para grupos de Maracatu que irão se apresentar no Carnaval Cultural.',
            'createdBy' => AgentFixtures::AGENT_ID_5,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_5,
            'project' => InitiativeFixtures::INITIATIVE_ID_5,
            'event' => EventFixtures::EVENT_ID_5,
            'createdAt' => '2024-09-10T14:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_6,
            'name' => 'Chamada para Exposição de Artes Visuais - Mostra Nordeste de Arte Contemporânea',
            'description' => 'Inscrições abertas para artistas visuais interessados em participar da Mostra Nordeste de Arte Contemporânea.',
            'createdBy' => AgentFixtures::AGENT_ID_6,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_6,
            'project' => InitiativeFixtures::INITIATIVE_ID_6,
            'event' => EventFixtures::EVENT_ID_6,
            'createdAt' => '2024-09-11T15:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_7,
            'name' => 'Inscrição para Palestras sobre Culinária Regional - Festival Gastronômico Nordestino',
            'description' => 'Chefs e estudiosos da culinária nordestina podem se inscrever para palestras no Festival Gastronômico.',
            'createdBy' => AgentFixtures::AGENT_ID_7,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_7,
            'project' => InitiativeFixtures::INITIATIVE_ID_7,
            'event' => EventFixtures::EVENT_ID_7,
            'createdAt' => '2024-09-12T16:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_8,
            'name' => 'Convocatória para Mostra de Filmes Nordestinos - Cine Nordeste',
            'description' => 'Cineastas podem inscrever seus filmes para exibição na Mostra de Filmes Nordestinos.',
            'createdBy' => AgentFixtures::AGENT_ID_8,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_8,
            'project' => InitiativeFixtures::INITIATIVE_ID_8,
            'event' => EventFixtures::EVENT_ID_8,
            'createdAt' => '2024-09-13T17:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_9,
            'name' => 'Chamada para Oficinas de Teatro de Rua - Encontro de Artes Cênicas Nordestinas',
            'description' => 'Teatralistas podem se inscrever para ministrar oficinas de teatro de rua no Encontro de Artes Cênicas.',
            'createdBy' => AgentFixtures::AGENT_ID_9,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_9,
            'project' => InitiativeFixtures::INITIATIVE_ID_9,
            'event' => EventFixtures::EVENT_ID_9,
            'createdAt' => '2024-09-14T18:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
        [
            'id' => self::OPPORTUNITY_ID_10,
            'name' => 'Edital para Seleção de Artistas de Rua - Circuito Cultural Nordestino',
            'description' => 'Artistas de rua podem se inscrever para participar do Circuito Cultural Nordestino, promovendo a cultura popular.',
            'createdBy' => AgentFixtures::AGENT_ID_10,
            'parent' => null,
            'space' => SpaceFixtures::SPACE_ID_10,
            'project' => InitiativeFixtures::INITIATIVE_ID_10,
            'event' => EventFixtures::EVENT_ID_10,
            'createdAt' => '2024-09-15T19:00:00+00:00',
            'updatedAt' => null,
            'deletedAt' => null,
        ],
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::OPPORTUNITIES as $opportunityData) {
            /* @var Opportunity $opportunity */
            $opportunity = $this->serializer->denormalize($opportunityData, Opportunity::class);

            $opportunity->setCreatedBy($this->getReference(sprintf('%s-%s', AgentFixtures::AGENT_ID_PREFIX, $opportunityData['createdBy'])));

            if (null !== $opportunityData['parent']) {
                $parent = $this->getReference(sprintf('%s-%s', self::OPPORTUNITY_ID_PREFIX, $opportunityData['parent']));
                $opportunity->setParent($parent);
            }

            if (null !== $opportunityData['space']) {
                $space = $this->getReference(sprintf('%s-%s', SpaceFixtures::SPACE_ID_PREFIX, $opportunityData['space']));
                $opportunity->setSpace($space);
            }

            if (null !== $opportunityData['project']) {
                $project = $this->getReference(sprintf('%s-%s', InitiativeFixtures::INITIATIVE_ID_PREFIX, $opportunityData['project']));
                $opportunity->setProject($project);
            }

            if (null !== $opportunityData['event']) {
                $event = $this->getReference(sprintf('%s-%s', EventFixtures::EVENT_ID_PREFIX, $opportunityData['event']));
                $opportunity->setEvent($event);
            }

            $this->setReference(sprintf('%s-%s', self::OPPORTUNITY_ID_PREFIX, $opportunityData['id']), $opportunity);

            $manager->persist($opportunity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            SpaceFixtures::class,
            InitiativeFixtures::class,
            EventFixtures::class,
        ];
    }
}
