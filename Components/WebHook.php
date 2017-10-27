<?php

namespace Badah\WpSupport\Components;

class WebHook
{
    /**
     * Recebe Post de Notificação
     *
     * @return string|false   Conteúdo enviado por agente externo a este endpoint.
     */
    public static function getPost()
    {
        $post = file_get_contents('php://input');
        if (empty($post)) {
            $post = json_encode($_POST);
        }

        if(!is_null(json_decode($post))) {
            return json_decode($post, true);
        }

        parse_str($post, $post);
        return $post;
    }

    /**
     * Recebe Post de Notificação
     *
     * @return array|boolean   Conteúdo enviado por agente externo a este endpoint.
     */
    public static function havePostParam($param)
    {
        $post = self::getPost();
        if(isset($post[$param]) && !empty($post[$param])) {
            return $post;
        }
        return false;
    }

    /**
     * Grava o post de notificação
     * @todo Limitar o tamanho do arquivo
     */
    static public function recordPost()
    {
        $body = self::getPost();
        $file = fopen(getcwd().'/post-notificacao.txt', 'a');
        $txt = '';
        $txt .= '[' . date('Y/m/d H:i:s') . '] ' . json_encode($body) . PHP_EOL;
        fwrite($file, $txt);
        fclose($file);
    }
}