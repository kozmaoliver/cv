<?php

declare(strict_types=1);

namespace App\Controller\Cms\Auth;

use App\Form\Auth\LoginType;
use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorTokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsController]
#[Route(path: '/login', name: 'auth_login', methods: ['GET', 'POST'])]
class LoginController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly AuthenticationUtils   $utils,
        private readonly TranslatorInterface   $translator
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $token = $this->tokenStorage->getToken();

        if ($token instanceof TwoFactorTokenInterface) {
            return $this->redirectToRoute('2fa_login');
        }

        if ($token !== null) {
            return $this->redirectToRoute('cms_index');
        }

        $form = $this->createForm(LoginType::class, [
            '_username' => $this->utils->getLastUsername()
        ]);

        $error = $this->utils->getLastAuthenticationError();

        if ($error !== null) {
            $message = $this->translator->trans($error->getMessageKey(), $error->getMessageData(), 'security'); //TODO

            $formError = new FormError($message, cause: $error);
            $form->get('_username')->addError($formError);
        }

        return $this->render('cms/auth/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}