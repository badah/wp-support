<?php

namespace StudioVisual\Support\Components;

abstract class HttpResponse
{
    protected $body;

    protected $headers;

    protected $status_code;

    public function __construct( $data ) {

        $this->body = json_decode( wp_remote_retrieve_body( $data ), true );
        $this->headers = wp_remote_retrieve_headers( $data );
        $this->status_code = wp_remote_retrieve_response_code( $data );

    }

    protected function is_valid() {

        if ( is_wp_error( $this->body ) ) {
            return false;
        }

        if ( 200 !== $this->get_status_code() ) {
            return false;
        }

        return true;

    }

    abstract public function is_positive();

    public function get_data() {

        return $this->body;
    }

    public function get_status_code() {

        return $this->status_code;

    }

}