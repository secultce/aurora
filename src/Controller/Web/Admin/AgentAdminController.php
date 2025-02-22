<?php

declare(strict_types=1);

namespace App\Controller\Web\Admin;

use App\Document\AgentTimeline;
use App\DocumentService\AgentTimelineDocumentService;
use App\Enum\FlashMessageTypeEnum;
use App\Exception\ValidatorException;
use App\Service\Interface\AgentServiceInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class AgentAdminController extends AbstractAdminController
{
    private const string VIEW_ADD = 'agent/create.html.twig';

    public const CREATE_FORM_ID = 'add-agent';

    public function __construct(
        private AgentServiceInterface $service,
        private AgentTimelineDocumentService $documentService,
        private JWTTokenManagerInterface $jwtManager,
        private TranslatorInterface $translator,
        private Security $security,
        private readonly AgentTimeline $agentTimeline,
    ) {
    }

    public function list(UserInterface $user): Response
    {
        $agents = $this->service->findBy();

        $token = $this->jwtManager->create($user);

        return $this->render('agent/list.html.twig', [
            'agents' => $agents,
            'token' => $token,
        ]);
    }

    public function create(Request $request): Response
    {
        if (false === $request->isMethod(Request::METHOD_POST)) {
            return $this->render(self::VIEW_ADD, [
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        $this->validCsrfToken(self::CREATE_FORM_ID, $request);

        $errors = [];

        try {
            $this->service->create([
                'id' => Uuid::v4(),
                'name' => $request->get('name'),
                'shortBio' => $request->get('shortBio'),
                'longBio' => $request->get('shortBio'),
                'culture' => false,
                'user' => $this->security->getUser()->getId(),
            ]);

            $this->addFlash(FlashMessageTypeEnum::SUCCESS->value, $this->translator->trans('view.agent.message.created'));
        } catch (ValidatorException $exception) {
            $errors = $exception->getConstraintViolationList();
        } catch (Exception $exception) {
            $errors = [$exception->getMessage()];
        }

        if (false === empty($errors)) {
            return $this->render(self::VIEW_ADD, [
                'errors' => $errors,
                'form_id' => self::CREATE_FORM_ID,
            ]);
        }

        return $this->redirectToRoute('admin_agent_list');
    }

    public function timeline(?Uuid $id): Response
    {
        $events = $this->documentService->getEventsByEntityId($id);

        $events = $this->agentTimeline->getEvents($events);

        return $this->render('agent/timeline.html.twig', [
            'agent' => $this->service->get($id),
            'events' => $events,
        ]);
    }

    public function remove(?Uuid $id): Response
    {
        $this->service->remove($id);

        $this->addFlash('success', 'view.agent.message.deleted');

        return $this->redirectToRoute('admin_agent_list');
    }
}
