<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Exception\ValidatorException;
use App\Service\Interface\SpaceTypeServiceInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class SpaceTypeAdminController extends AbstractAdminController
{
    private const string LIST = 'space-type/list.html.twig';
    private const string CREATE = 'space-type/create.html.twig';
    private const string CREATE_FORM_ID = 'add-space-type';

    public function __construct(
        private readonly SpaceTypeServiceInterface $service,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function list(): Response
    {
        $spaceTypes = $this->service->list();

        return $this->render(self::LIST, [
            'spaceTypes' => $spaceTypes,
        ]);
    }

    public function create(Request $request): Response
    {
        if (false === $request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::CREATE, [
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        $errors = [];

        try {
            $this->service->create([
                'id' => Uuid::v4(),
                'name' => $request->get('name'),
            ]);

            $this->addFlashSuccess($this->translator->trans('view.space_type.message.created'));
        } catch (ValidatorException $exception) {
            $errors = $exception->getConstraintViolationList();
        } catch (Exception $exception) {
            $errors = [$exception->getMessage()];
        }

        if (false === empty($errors)) {
            return $this->render(self::CREATE, [
                'errors' => $errors,
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        return $this->redirectToRoute('admin_space_type_list');
    }
}
