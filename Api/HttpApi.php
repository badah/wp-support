<?php

namespace StudioVisual\Support\Api;


class HttpApi
{
    /**
     * @param $url
     * @param array $body
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    static public function post($url, $body = [], $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'application/json', 'Accept' => 'application/json'], $headers);

        $args = [
            'timeout' => 45,
            'headers' => $headers,
            'body'    => json_encode($body),
        ];

        $response = wp_remote_post($url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $success = [200, 201];

        if (is_wp_error($response)) {
            return $response->get_error_codes();
        }

        if (!in_array($code, $success)) {
            $message = json_decode(wp_remote_retrieve_body($response), true);
            throw new \Exception($message[0]['message'] ?? '', $code);
        }

        return [
            'body'    => json_decode(wp_remote_retrieve_body($response), true),
            'headers' => wp_remote_retrieve_headers($response)
        ];
    }

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    static public function get($url, $params = [], $headers = [])
    {

        $headers = array_merge(['Content-Type' => 'application/json', 'Accept' => 'application/json'], $headers);

        $args = [
            'headers' => $headers,
            'timeout' => 45,
        ];

        $response = wp_remote_get($url, $args);

        $code = wp_remote_retrieve_response_code($response);
        if (200 !== $code) {
            throw new \Exception($code . ' - ' . \wp_remote_retrieve_response_message($response));
        }

        return [
            'body'    => json_decode(wp_remote_retrieve_body($response), true),
            'headers' => wp_remote_retrieve_headers($response)
        ];
    }

    /**
     * @param $url
     * @param array $body
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    static public function delete($url, $body = [], $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'application/json', 'Accept' => 'application/json'], $headers);

        $args = [
            'method'  => 'DELETE',
            'timeout' => 45,
            'headers' => $headers,
            'body'    => json_encode($body),
        ];

        $response = wp_remote_request($url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $success = [200, 201];

        if (!in_array($code, $success)) {
            throw new \Exception($code . ' - ' . \wp_remote_retrieve_response_message($response));
        }

        return [
            'body'    => json_decode(wp_remote_retrieve_body($response), true),
            'headers' => wp_remote_retrieve_headers($response)
        ];
    }

    /**
     * @param $url
     * @param array $params
     * @param array $headers
     * @param array $file
     * @return array
     * @throws \Exception
     */
    public static function postFile($url, $params = [], $headers = [], $file = [])
    {
        // initialise the curl request
        $request = curl_init($url);

        $headers = array_merge(['Content-Type' => 'multipart/form-data'], $headers);

        $file = [
            'Arquivo' => '@' . realpath($file['tmp_name']) . ';filename='.$file['name']
        ];

        $params = array_merge($file, $params);

        // send a file
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, $params);
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);

        // output the response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($request);

        $code = curl_getinfo($request, CURLINFO_HTTP_CODE);

        // close the session
        curl_close($request);

        $success = [200, 201];
        if (!in_array($code, $success)) {
            throw new \Exception($code);
        }

        return [
            'body' => json_decode($response, true),
        ];
    }

    /**
     * @param $url
     * @param array $body
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    static public function put($url, $body = [], $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'application/json', 'Accept' => 'application/json'], $headers);

        $args = [
            'method'  => 'PUT',
            'timeout' => 45,
            'headers' => $headers,
            'body'    => json_encode($body),
        ];

        $response = wp_remote_request($url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $success = [200, 201];

        if (!in_array($code, $success)) {
            throw new \Exception($code . ' - ' . \wp_remote_retrieve_response_message($response));
        }

        return [
            'body'    => json_decode(wp_remote_retrieve_body($response), true),
            'headers' => wp_remote_retrieve_headers($response)
        ];
    }
}
