<?php

declare(strict_types=1);

namespace Service;

use Service\Exception\SessionException;

class Session
{
    /**
     * @throws SessionException
     */
    public static function start(): void
    {
        switch (session_status()) {
            case PHP_SESSION_ACTIVE:
                break;
            case PHP_SESSION_NONE:
                if (headers_sent()) {
                    throw new SessionException('Impossible de modifier les entetes HTTP');
                }
                if (!session_start()) {
                    throw new SessionException('Impossible de démarré la session');
                }
                break;
            case PHP_SESSION_DISABLED:
                throw new SessionException('Les sessions sont désactivées');
            default:
                throw new SessionException('erreur inconnue');
        }
    }
}
