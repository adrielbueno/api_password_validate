<?php

namespace App\Core\Utils;

use App\Model\Atividade;
use App\Model\Cartao;
use App\Model\Coban;
use App\Model\TaxaOperadoraFundo;
use App\Model\TaxaUsuario;
use App\Model\Transacao;
use App\Model\Usuario;
use App\Model\Vendedor;
use App\Core\Handlers\Response\ResponseHandler as RBMMensagens;

class Str
{   

    /**
     * Formata a url para o padrão
     * @author Jonas Vicente
     * @param string $url
     * @return string
     */
    public static function setUrlPattern(string $url): string
    {
        $url = explode('?', $url);
        return preg_replace('/\/$/', '', preg_replace('/^\//', '', trim($url[0])));
    }
   
}
