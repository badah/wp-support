<?php

namespace StudioVisual\Support\Components;

class HttpResponse
{
    protected $data;

    protected $headers;

    protected $status_code;

    public function __construct( $data ) {
        $this->data = json_decode( wp_remote_retrieve_body( $data ), true );
        $this->headers = wp_remote_retrieve_headers( $data );
        $this->status_code = wp_remote_retrieve_response_code( $data );
    }

    public function is_valid() {

        if ( ! isset( $this->data['response'] ) ) {
            return false;
        }

        if ( is_wp_error( $this->data ) ) {
            return false;
        }

        if ( 200 !== $this->status_code && 'success' !== $this->data['response'] ) {
            return false;
        }

        if ( 'error' === $this->data['response'] ) {
            return false;
        }

        return true;
    }

    public function get() {

        return $this->data;

    }

    public function get_status_code() {

        return $this->status_code;

    }

}