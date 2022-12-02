<?php

/**
 * Require route files
 *
 * @return void
 */
function requireRouteFiles(): void
{
    recursiveRequire('app/routes/');
}

/**
 * Include files recursively in a given folder
 *
 * @param string $dir
 * @return void
 */
function recursiveRequire(string $dir): void
{
    foreach (new \DirectoryIterator($dir) as $f) {
        if (!$f->isDot()) {
            $f->isDir() ? recursiveRequire($dir . $f->getFilename() . "/") : require $dir . $f->getFilename();
        }
    }
}


if (!function_exists('apache_request_headers')) {
    /**
     * Declare apache_request_headers function if it doesn't exist
     *
     * @return array
     */
    function apache_request_headers(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

/**
 * Handles fatal errors that may occur in the system
 *
 * @return void json
 */
function catch_fatal_error(): void
{
    $lastError     = error_get_last();
    $captureErrors = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

    if ($lastError !== null && in_array($lastError['type'], $captureErrors)) {
        $file     = $lastError['file'];
        $fileLine = $lastError['line'];
        $message  = $lastError['message'];

        $file = explode(DIRECTORY_SEPARATOR, $file);
        $file = $file[count($file) - 2] . '/' . $file[count($file) - 1];
        $file = str_replace('.php', '', $file);

        if (strpos($message, 'Stack trace:') !== false) {
            $message = explode('Stack trace:', $message);
            $message = $message[0];
        }

        if (strpos($message, "\n") !== false) {
            $message = explode("\n", $message);
            $auxArray = [];
            foreach ($message as $msg) {
                if (!empty($msg)) {
                    $auxArray[] = str_replace(
                        '.php',
                        '',
                        str_replace(DIRECTORY_SEPARATOR, '/', str_replace(__DIR__, '', $msg))
                    );
                }
            }
            $message = count($auxArray) > 1 ? $auxArray : $auxArray[0];
        }

        App\Core\Handlers\Response\ResponseHandler::printJson(500, ["error" => [
            "arquivo"  => $file,
            "linha"    => $fileLine,
            "mensagem" => $message,
        ]]);
    }
}
