<?php

namespace Badah\WpSupport\Components;

class Http_Request {

	public function post( $url, $body = [], $headers = [] ) {
		$headers = array_merge(
			[
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			], $headers
		);

		$args = [
			'timeout' => 45,
			'headers' => $headers,
			'body'    => wp_json_encode( $body ),
		];

		$response = wp_remote_post( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );
		$success  = [ 200, 201 ];

		if ( is_wp_error( $response ) ) {
			return $response->get_error_codes();
		}

		if ( ! in_array( $code, $success, true ) ) {
			$message = json_decode( wp_remote_retrieve_body( $response ), true );
			throw new \Exception( $message[0]['message'] ?? '', $code );
		}

		return [
			'body'    => json_decode( wp_remote_retrieve_body( $response ), true ),
			'headers' => wp_remote_retrieve_headers( $response ),
		];
	}

	public function get( $url, $params = [], $headers = [] ) {

		$headers = array_merge(
			[
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			], $headers
		);

		$args = [
			'headers' => $headers,
			'timeout' => 45,
		];

		$response = wp_remote_get( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );

		if ( 200 !== $code ) {
			throw new \Exception( $code . ' - ' . \wp_remote_retrieve_response_message( $response ) );
		}

		return [
			'body'    => json_decode( wp_remote_retrieve_body( $response ), true ),
			'headers' => wp_remote_retrieve_headers( $response ),
		];
	}

	public function delete( $url, $body = [], $headers = [] ) {
		$headers = array_merge(
			[
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			], $headers
		);

		$args = [
			'method'  => 'DELETE',
			'timeout' => 45,
			'headers' => $headers,
			'body'    => wp_json_encode( $body ),
		];

		$response = wp_remote_request( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );
		$success  = [ 200, 201 ];

		if ( ! in_array( $code, $success, true ) ) {
			throw new \Exception( $code . ' - ' . \wp_remote_retrieve_response_message( $response ) );
		}

		return [
			'body'    => json_decode( wp_remote_retrieve_body( $response ), true ),
			'headers' => wp_remote_retrieve_headers( $response ),
		];
	}

	public static function post_file( $url, $params = [], $headers = [], $file = [] ) {
		$request = curl_init( $url );

		$headers = array_merge(
			[
				'Content-Type' => 'multipart/form-data',
			], $headers
		);

		$file = [
			'Arquivo' => '@' . realpath( $file['tmp_name'] ) . ';filename=' . $file['name'],
		];

		$params = array_merge( $file, $params );

		// send a file
		curl_setopt( $request, CURLOPT_POST, true );
		curl_setopt( $request, CURLOPT_POSTFIELDS, $params );
		curl_setopt( $request, CURLOPT_HTTPHEADER, $headers );

		// output the response
		curl_setopt( $request, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec( $request );

		$code = curl_getinfo( $request, CURLINFO_HTTP_CODE );

		// close the session
		curl_close( $request );

		$success = [ 200, 201 ];
		if ( ! in_array( $code, $success, true ) ) {
			throw new \Exception( $code );
		}

		return [
			'body' => json_decode( $response, true ),
		];
	}

	public static function put( $url, $body = [], $headers = [] ) {
		$headers = array_merge(
			[
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json',
			], $headers
		);

		$args = [
			'method'  => 'PUT',
			'timeout' => 45,
			'headers' => $headers,
			'body'    => wp_json_encode( $body ),
		];

		$response = wp_remote_request( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );
		$success  = [ 200, 201 ];

		if ( ! in_array( $code, $success, true ) ) {
			throw new \Exception( $code . ' - ' . \wp_remote_retrieve_response_message( $response ) );
		}

		return [
			'body'    => json_decode( wp_remote_retrieve_body( $response ), true ),
			'headers' => wp_remote_retrieve_headers( $response ),
		];
	}
}
