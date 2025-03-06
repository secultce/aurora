<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\FaqDto;
use App\Entity\Faq;
use App\Exception\Faq\FaqResourceNotFoundException;
use App\Repository\Interface\FaqRepositoryInterface;
use App\Service\Interface\FaqServiceInterface;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class FaqService extends AbstractEntityService implements FaqServiceInterface
{
    public function __construct(
        private FaqRepositoryInterface $repository,
        private Security $security,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct($this->security, $this->serializer, $this->validator);
    }

    public function create(array $faq): Faq
    {
        $faq = $this->validateInput($faq, FaqDto::class, FaqDto::CREATE);

        $faqObj = $this->serializer->denormalize($faq, Faq::class);

        return $this->repository->save($faqObj);
    }

    public function get(Uuid $id): Faq
    {
        $faq = $this->repository->findOneBy(['id' => $id, 'active' => true]);

        if (null === $faq) {
            throw new FaqResourceNotFoundException();
        }

        return $faq;
    }

    public function update(Uuid $identifier, array $faq): Faq
    {
        $faqFromDB = $this->get($identifier);

        $faqDto = $this->validateInput($faq, FaqDto::class, FaqDto::UPDATE);

        $faqObj = $this->serializer->denormalize($faqDto, Faq::class, context: [
            'object_to_populate' => $faqFromDB,
        ]);

        $faqObj->setUpdatedAt(new DateTime());

        return $this->repository->save($faqObj);
    }

    public function list(int $limit = 50): array
    {
        return $this->repository->findBy(
            ['active' => true],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function remove(Uuid $id): void
    {
        $faq = $this->get($id);

        $faq->setUpdatedAt(new DateTime());
        $faq->setActive(false);

        $this->repository->save($faq);
    }
}
