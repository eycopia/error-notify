<?php
/*
 * Este es una adaptación de la clase para enviar email
 */

namespace ErrorNotify;

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\DebugClassLoader;
/**
 * Registers all the debug tools.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * Modified by Jorge Copia
 */
class Debug
{
    private static $enabled = false;

    /**
     * Enables the debug tools.
     *
     * This method registers an error handler and an exception handler.
     *
     * If the Symfony ClassLoader component is available, a special
     * class loader is also registered.
     *
     * @param interfaceNotify  $classNotify Class to send notification
     * @param int  $errorReportingLevel The level of error reporting you want
     * @param bool $displayErrors       Whether to display errors (for development) or just log them (for production)
     */
    public static function enable(interfaceNotify $classNotify, $errorReportingLevel = null, $displayErrors = true)
    {
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        if (null !== $errorReportingLevel) {
            error_reporting($errorReportingLevel);
        } else {
            error_reporting(-1);
        }
        ExceptionHandler::register($classNotify);
        $handler = ErrorHandler::register();
        if (!$displayErrors) {
            $handler->throwAt(0, true);
        }

        DebugClassLoader::enable();
    }
}
