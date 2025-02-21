<?php

declare(strict_types=1);

namespace App\DataFixtures\Entity;

use App\Entity\Faq;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class FaqFixtures extends AbstractFixture
{
    public const string FAQ_ID_PREFIX = 'faq';
    public const string FAQ_ID_1 = '1cc8c68a-b0cd-4cb3-bd9d-41a9161b3560';
    public const string FAQ_ID_2 = '14a5b3da-a7a4-49a6-aff8-902a325f97f0';
    public const string FAQ_ID_3 = '1da862ea-0dc7-45c4-9bed-751ff379e9d0';
    public const string FAQ_ID_4 = '107a3bda-ce3a-4608-b2ae-6a22048630c0';
    public const string FAQ_ID_5 = '19cd7a3a-2e48-4f09-b091-04cadf8e8a50';
    public const string FAQ_ID_6 = '19a9acca-3cf5-4631-a29c-2cc31f9278e0';
    public const string FAQ_ID_7 = '1250a8ca-b4f9-41e9-bb8a-e78606001430';
    public const string FAQ_ID_8 = '12923f1a-b744-41ad-bd45-ebf99a599800';
    public const string FAQ_ID_9 = '17a5640a-ca46-4612-9e53-a797f3b8f110';

    public const array FAQS = [
        [
            'id' => self::FAQ_ID_1,
            'question' => 'Onde posso acessar editais para projetos culturais no Brasil?',
            'answer' => 'Você pode encontrar editais no site do Ministério da Cultura (Minc), na Funarte e nas Secretarias Estaduais de Cultura. Por exemplo, o Edital de Fomento à Cultura Negra 2024 está disponível na Funarte.',
            'active' => true,
            'createdAt' => '2024-07-10T11:30:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_2,
            'question' => 'Quais iniciativas apoiam startups no Brasil atualmente?',
            'answer' => 'Iniciativas como o programa Startup Brasil, Sebrae Startup SP e o BNDES Garagem oferecem suporte financeiro, capacitação e mentoria para startups.',
            'active' => true,
            'createdAt' => '2024-07-11T10:49:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_3,
            'question' => 'Como faço para me inscrever em um programa de bolsa de estudos internacional?',
            'answer' => 'Você pode verificar programas como Fulbright, Chevening e Erasmus Mundus. Consulte os requisitos diretamente nos sites oficiais e prepare sua documentação com antecedência.',
            'active' => true,
            'createdAt' => '2024-07-16T17:22:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_4,
            'question' => 'Quais oportunidades existem para pesquisadores acadêmicos no Brasil?',
            'answer' => 'O CNPq e a Capes oferecem bolsas para pesquisa acadêmica. O edital Universal do CNPq está aberto para submissões em diversas áreas do conhecimento.',
            'active' => true,
            'createdAt' => '2024-07-17T15:12:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_5,
            'question' => 'Como cadastrar meu projeto em plataformas de crowdfunding?',
            'answer' => 'Plataformas como Catarse e Benfeitoria exigem que você crie um perfil, elabore uma apresentação atraente para o projeto e estabeleça metas de arrecadação claras.',
            'active' => true,
            'createdAt' => '2024-07-22T16:20:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_6,
            'question' => 'Quais iniciativas sociais apoiam mulheres empreendedoras no Brasil?',
            'answer' => 'Programas como o “Ela Pode” (Instituto Rede Mulher Empreendedora) oferecem capacitação gratuita, e o “WE Ventures” apoia startups lideradas por mulheres.',
            'active' => true,
            'createdAt' => '2024-08-10T11:26:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_7,
            'question' => 'Há editais para iniciativas ambientais?',
            'answer' => 'Sim, o Fundo Amazônia e o programa Petrobras Socioambiental oferecem editais para apoiar projetos focados em sustentabilidade e conservação ambiental.',
            'active' => true,
            'createdAt' => '2024-08-11T15:54:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_8,
            'question' => 'Como me inscrever para cursos gratuitos do SENAI?',
            'answer' => 'Acesse o site oficial do SENAI de sua região, procure pelos cursos disponíveis e siga as orientações para inscrição online.',
            'active' => true,
            'createdAt' => '2024-08-12T14:24:00+00:00',
            'updatedAt' => null,
        ],
        [
            'id' => self::FAQ_ID_9,
            'question' => 'Quais iniciativas apoiam jovens em situação de vulnerabilidade?',
            'answer' => 'Iniciativas como o Jovem Aprendiz, os programas do Instituto Ayrton Senna e as ações da Fundação Abrinq oferecem oportunidades de capacitação e trabalho.',
            'active' => false,
            'createdAt' => '2024-08-13T20:25:00+00:00',
            'updatedAt' => null,
        ],
    ];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TokenStorageInterface $tokenStorage,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct($entityManager, $tokenStorage);
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::FAQS as $faqData) {
            /** @var Faq $faq */
            $faq = $this->serializer->denormalize($faqData, Faq::class, context: ['object_to_populate' => $faqData]);

            $manager->persist($faq);
        }

        $manager->flush();
    }
}
