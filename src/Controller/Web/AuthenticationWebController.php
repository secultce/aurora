<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Exception\ValidatorException;
use App\Service\Interface\UserServiceInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthenticationWebController extends AbstractWebController
{
    public const REGISTER_FORM_ID = 'add-user';

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly UserServiceInterface $userService,
        private readonly Security $security,
    ) {
    }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if (null !== $this->getUser()) {
            return $this->redirectToRoute('web_home_homepage');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('authentication/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    public function register(Request $request): Response
    {
        if (null !== $this->security->getUser()) {
            $this->addFlash('error', 'view.authentication.error.already_logged_in');

            return $this->redirectToRoute('web_home_homepage');
        }

        $error = null;

        if (false === $request->isMethod('POST')) {
            return $this->render('authentication/register.html.twig', [
                'error' => $error,
                'form_id' => self::REGISTER_FORM_ID,
            ]);
        }

        $this->validCsrfToken(self::REGISTER_FORM_ID, $request);

        $firstName = $request->request->get('first_name');
        $lastName = $request->request->get('last_name');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $cpf = str_replace(['.', '-'], '', $request->request->get('cpf'));
        $phone = str_replace(['(', ')', '-', ' '], '', $request->request->get('phone'));

        try {
            $this->userService->create([
                'id' => Uuid::v4(),
                'firstname' => $firstName,
                'lastname' => $lastName,
                'email' => $email,
                'password' => $password,
                'cpf' => $cpf,
                'phone' => $phone,
            ]);

            return $this->render('authentication/register_success.html.twig');
        } catch (UniqueConstraintViolationException $exception) {
            $error = $this->translator->trans('view.authentication.error.email_in_use');
        } catch (ValidatorException $exception) {
            $violations = $exception->getConstraintViolationList();
            if ($violations->count() > 0) {
                $error = $violations->get(0)->getMessage();
            }
        } catch (Exception $exception) {
            $error = $this->translator->trans('view.authentication.error.error_message').$exception->getMessage();
        }

        return $this->render('authentication/register.html.twig', [
            'error' => $error,
            'form_id' => self::REGISTER_FORM_ID,
        ]);
    }
}
