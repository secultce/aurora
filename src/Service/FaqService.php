<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\FaqDto;
use App\Entity\Faq;
use App\Exception\Faq\FaqResourceNotFoundException;
use App\Exception\ValidatorException;
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
        parent::__construct($security);
    }

    public function create(array $faq): Faq
    {
        $faqDto = $this->serializer->denormalize($faq, FaqDto::class);

        $violations = $this->validator->validate($faqDto, groups: FaqDto::CREATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $faqObj = $this->serializer->denormalize($faq, Faq::class);

        return $this->repository->save($faqObj);
    }

    public function get(Uuid $id): Faq
    {
        $faq = $this->repository->find($id);

        if (null === $faq) {
            throw new FaqResourceNotFoundException();
        }

        return $faq;
    }

    public function update(Uuid $identifier, array $faq): Faq
    {
        $faqFromDB = $this->get($identifier);

        $faqDto = $this->serializer->denormalize($faq, FaqDto::class);

        $violations = $this->validator->validate($faqDto, groups: FaqDto::UPDATE);

        if ($violations->count() > 0) {
            throw new ValidatorException(violations: $violations);
        }

        $faqObj = $this->serializer->denormalize($faq, Faq::class, context: [
            'object_to_populate' => $faqFromDB,
        ]);

        $faqObj->setUpdatedAt(new DateTime());

        return $this->repository->save($faqObj);
    }
}
