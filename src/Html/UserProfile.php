<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function toHtml(): string
    {
        return <<<HTML
<p>Nom : {$this->escapeString((string) $this->user->getLastName())}</p>
<p>Prénom : {$this->escapeString((string) $this->user->getFirstName())}</p>
<p>Login : {$this->escapeString((string) $this->user->getLogin())}</p>
<p>Téléphone : {$this->escapeString((string) $this->user->getPhone())}</p>
HTML;
    }
}
