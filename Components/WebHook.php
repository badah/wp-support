<?php

namespace Badah\WpSupport\Components;

class WebHook {

	public static function getPost() {
		$post = file_get_contents( 'php://input' );
		if ( empty( $post ) ) {
			$post = json_encode( $_POST );
		}

		if ( ! is_null( json_decode( $post ) ) ) {
			return json_decode( $post, true );
		}

		parse_str( $post, $post );
		return $post;
	}

	public static function havePostParam( $param ) {
		$post = self::getPost();
		if ( isset( $post[ $param ] ) && ! empty( $post[ $param ] ) ) {
			return $post;
		}
		return false;
	}

	static public function recordPost() {
		$body = self::getPost();
		$file = fopen( getcwd() . '/post-notificacao.txt', 'a' );
		$txt = '';
		$txt .= '[' . date( 'Y/m/d H:i:s' ) . '] ' . json_encode( $body ) . PHP_EOL;
		fwrite( $file, $txt );
		fclose( $file );
	}
}
