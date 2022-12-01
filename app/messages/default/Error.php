<?php

/**
 * @range D
 */

use App\Core\Handlers\Response\Messages;

Messages::getInstance()
    ->addMessage('D999-999', 'Ocorreu um erro!')
    ->addMessage('D000-001', 'Algo inesperado aconteceu!');
