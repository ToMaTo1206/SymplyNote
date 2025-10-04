<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\NotLoggedInException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Service\Exception\SessionException;
use Service\Session;

class UserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    private const SESSION_KEY = '__UserAuthentication__';

    private const SESSION_USER_KEY = 'user';

    private ?User $user = null;

    private const LOGOUT_INPUT_NAME = 'logout';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $loginName = self::LOGIN_INPUT_NAME;
        $passwordName = self::PASSWORD_INPUT_NAME;

        return <<<HTML
        <form method="post" action="$action">
        <label><input type="text" name="{$loginName}" required placeholder="login"></label>
        
        <label><input type="password" name="{$passwordName}" required placeholder="pass"></label>
        <button type="submit">{$submitText}</button>
</form>
    

HTML;
    }

    /**
     * @throws EntityNotFoundException
     * @throws SessionException
     * @throws NotLoggedInException
     */
    public function getUserFromAuthentication(): User
    {
        if (!isset($_POST[self::LOGIN_INPUT_NAME])) {
            throw new NotLoggedInException("Échec de l'authentification car pas de login ");
        }

        if (!isset($_POST[self::PASSWORD_INPUT_NAME])) {
            throw new NotLoggedInException("Échec de l'authentification car pas de password");

        }
        $password = $_POST[self::PASSWORD_INPUT_NAME];
        $login = $_POST[self::LOGIN_INPUT_NAME];

        $user = User::findByCredentials($login, $password);

        $this->setUser($user);

        return $this->user;
    }

    /**
     * @throws SessionException
     */
    protected function setUser(User $user): void
    {
        Session::start();
        $this->user = $user;
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
    }

    /**
     * @throws SessionException
     */
    public function isUserConnected(): bool
    {
        Session::start();
        $user = false;

        if (isset($_SESSION[UserAuthentication::SESSION_KEY][UserAuthentication::SESSION_USER_KEY])) {
            $user = $_SESSION[UserAuthentication::SESSION_KEY][UserAuthentication::SESSION_USER_KEY];
        }

        return $user instanceof User;
    }

    public function logoutForm(string $action, string $text = 'Logout'): string
    {
        $loginName = self::LOGIN_INPUT_NAME;
        $passwordName = self::PASSWORD_INPUT_NAME;
        $logout = self::LOGOUT_INPUT_NAME;

        return <<<HTML
        <form method="post" action="$action">
        <label><input type="hidden" id="{$logout}" name="{$logout}" value="{$logout}"></label>
        
        <button type="submit">{$text}</button>
</form>
HTML;
    }

    /**
     * @throws SessionException
     */
    public function logoutIfRequested(): void
    {
        Session::start();
        if (isset($_POST[self::LOGOUT_INPUT_NAME])) {
            if ('logout' == $_POST[self::LOGOUT_INPUT_NAME]) {
                unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
                $this->user = null;
            }
        }
    }

    /**
     * @throws NotLoggedInException
     * @throws SessionException
     */
    protected function getUserFromSession(): User
    {
        if (!$this->isUserConnected()) {
            throw new NotLoggedInException("Pas d'utilisateur");
        }

        return $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY];
    }

    /**
     * @throws SessionException
     */
    public function __construct()
    {
        try {
            $user = $this->getUserFromSession();
            $this->user = $user;
        } catch (NotLoggedInException $e) {
        }
    }

    /**
     * @throws NotLoggedInException
     */
    public function getUser(): User
    {
        if (!isset($this->user)) {
            throw new NotLoggedInException("Pas d'utilisateur");
        }

        return $this->user;
    }
}
