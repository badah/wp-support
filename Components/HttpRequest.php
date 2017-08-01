<?php

namespace StudioVisual\Support\Components;

abstract class HttpRequest
{
    protected $url;

    protected $body = [];

    protected $headers = [];

    public function post() {

        $args = [
            'timeout' => 45,
            'headers' => $this->headers,
            'body'    => json_encode( $this->body ),
        ];

        return wp_remote_post( $this->url, $args );

    }

     public function get( $params = [] ) {

        $headers = array_merge([
        	'Content-Type' => 'application/json',
			'Accept' => 'application/json'],
			$this->headers
		);

        $args = [
            'headers' => $headers,
            'timeout' => 45,
        ];

        return wp_remote_get(add_query_arg( $params, esc_url_raw( $this->url ) ), $args);
    }

    public function delete($url, $body = [], $headers = []) {

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

    public function postFile($url, $params = [], $headers = [], $file = []) {

        // initialise the curl request
        $request = curl_init($url);

        $headers = array_merge(['Content-Type' => 'multipart/form-data'], $headers);

        $file = [
            'Arquivo' => '@' . realpath($file['tmp_name']) . ';filename=' . $file['name']
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

    public function put($url, $body = [], $headers = []) {

        $headers = array_merge([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ], $headers);

        $args = [
            'method'  => 'PUT',
            'timeout' => 45,
            'headers' => $headers,
            'body'    => json_encode($body),
        ];

        $response = wp_remote_request($url, $args);
        $code = wp_remote_retrieve_response_code($response);
        $success = [200, 201];

        if ( ! in_array( $code, $success ) ) {
            throw new \Exception($code . ' - ' . \wp_remote_retrieve_response_message( $response ) );
        }

        return [
            'body'    => json_decode( wp_remote_retrieve_body( $response ), true ),
            'headers' => wp_remote_retrieve_headers( $response )
        ];
    }
}
