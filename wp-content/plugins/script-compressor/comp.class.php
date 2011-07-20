<?php

/**
 * Javascript and CSS compressor class.
 *
 */
class Compressor {
	/**
	 * Target files
	 *
	 * @var array
	 */
	var $files;

	/**
	 * Target type (js or css)
	 *
	 * @var string
	 */
	var $type;

	/**
	 * Content charset.
	 *
	 * @var string
	 */
	var $charset;

	/**
	 * Whether compress by gzip.
	 *
	 * @var bool
	 */
	var $gzip;

	/**
	 * Whether replace paths
	 *
	 * @var bool
	 */
	var $replacePath;

	/**
	 * Cache directory.
	 *
	 * @var string
	 */
	var $cacheDir;

	/**
	 * Headers to send.
	 *
	 * @var array
	 */
	var $headers;

	/**
	 * Time that target was modified.
	 *
	 * @var integer
	 */
	var $lastModified;

	/**
	 * Initialize Compressor class.
	 *
	 * @param array $options Optionlist
	 *  - files
	 *      Target file(s).
	 *  - charset
	 *      Charset in content-type.
	 *  - gzip
	 *      Whether compress by gzip
	 *  - replacePath
	 *      Whether replace paths.
	 *  - cache
	 *      Cache directory.
	 *  - importCallback
	 *      Callback to change import url in CSS.
	 * @return Compressor
	 */
	function Compressor($options) {
		$this->options = $options + array(
			'charset' => 'utf-8',
			'gzip' => false,
			'replacePath' => false,
			'cache' => 'cache',
			'importCallback' => false
		);

		$this->options['files'] = (array)$this->options['files'];

		$this->headers = array();

		$js_files = $css_files = 0;
		$this->lastModified = 0;
		foreach ($this->options['files'] as $id => $file) {
			if (!preg_match('/(.+\.)(js|css)(?:\?.*)?$/iD', $file, $matches)) {
				unset($this->options['files'][$id]);
				continue;
			}

			$file = $matches[1] . $matches[2];

			if (file_exists($file)) {
				$fileLmt = @filemtime($file);
				if($fileLmt > $lastModified){
					$this->lastModified = $fileLmt;
				}
			} else {
				unset($this->options['files'][$id]);
				continue;
			}

			$this->options['files'][$id] = $file;

			if(strtolower($matches[2]) === 'js'){
				++$js_files;
			} else if (strtolower($matches[2]) === 'css'){
				++$css_files;
			}
		}
		if ($js_files > 0 && $css_files > 0) {
			$this->type = 'plain';
			$this->headers['Content-Type'] = 'text/plain; charset=' . $this->charset;
		} else if ($js_files > 0) {
			$this->type = 'js';
			$this->headers['Content-Type'] = 'text/javascript; charset=' . $this->charset;
		} else if ($css_files > 0) {
			$this->type = 'css';
			$this->headers['Content-Type'] = 'text/css; charset=' . $this->charset;
		} else if ($js_files + $css_files == 0) {
			$this->type = 'none';
		}

		$this->headers['Last-Modified'] = gmdate('D, d M Y H:i:s', $this->lastModified) . ' GMT';

		/* {{{ Check HTTP_IF_MODIFIED_SINCE */
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			if (!headers_sent() && $this->lastModified <= strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				$this->headers['HTTP'] = '304 Not Modified';
			}
		}
		/* }}} */

		/* {{{ Check gzip */
		$this->gzip = false;
		if ($this->options['gzip'] && function_exists('gzencode') && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strrpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false){
			$this->gzip = true;
			$enc = in_array('x-gzip', explode(',', strtolower(str_replace(' ', '', $_SERVER['HTTP_ACCEPT_ENCODING'])))) ? 'x-gzip' : 'gzip';
			$this->headers['Content-Encoding'] = $enc;
		}
		if ($this->gzip) {
			ini_set("zlib.output_compression", "Off");
			$this->headers['Vary'] = 'Accept-Encoding';
		}
		/* }}} */

		$this->headers['Cache-Control'] = 'must-revalidate';

		if (count($this->options['files']) == 0) {
			$this->headers['HTTP'] = '404 Not Found';
		}
	}

	/**
	 * Get target hash.
	 *
	 * @return string Taget hash (md5).
	 */
	function getHash() {
		return md5(implode(',', $this->options['files']));
	}

	/**
	 * Get composed target.
	 *
	 * @return string Composed content.
	 */
	function getComposed(){
		if ($this->type === 'none') return '';

		$content = '';
		foreach($this->options['files'] as $file){
			$file_content = file_get_contents($file) . "\n\n";
			if ($this->type === 'css') {
				if (preg_match_all('%url\(["\']?(.+?)["\']?\)|@import\s+(?:url\()?["\']?([^"\')]+)["\']?\)?%i', $file_content, $matches, PREG_SET_ORDER)) {
					$from = $to = array();
					foreach ($matches as $val) {
						if (isset($val[2])) {
							if (!preg_match('%(http://|data:)%', $val[2])) {
								$from[] = $val[0];
								$url = $this->getAbsUrl($file, $val[2]);
								if (is_callable($this->options['importCallback'])) {
									$url = call_user_func($this->options['importCallback'], $url);
								}
								$to[] = str_replace($val[2], $url, $val[0]);
							}
						} elseif ($this->options['replacePath']) {
							if (!preg_match('%(http://|data:)%', $val[1])) {
								$from[] = $val[0];
								$to[] = 'url("' . $this->getAbsUrl($file, $val[1]) . '")';
							}
						}
					}
					$file_content = str_replace($from, $to, $file_content);
				}
			}
			$content .= $file_content;
		}

		return $content;
	}

	/**
	 * Get absolute URL.
	 *
	 * @param string $base Base file path.
	 * @param string $url File path.
	 */
	function getAbsUrl($base, $url) {
		return '/' . ltrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($base)), '\\/') . '/' . preg_replace('%^\.?[/\\\\]%', '', $url);
	}

	/**
	 * Send required headers.
	 *
	 */
	function sendHeader() {
		foreach ($this->headers as $header => $var) {
			if ($header === 'HTTP') {
				header('HTTP/1.1 ' . $var);
			} else {
				header($header . ': ' . $var);
			}
		}
	}

	/**
	 * Compress target.
	 *
	 * @return string Compressed content.
	 */
	function getContent() {
		if ($this->type === 'none' || (isset($this->headers['HTTP']) && $this->headers['HTTP'] === '304 Not Modified')) return '';

		$cache_file = $this->options['cache'] . '/' . $this->getHash() . '-' . $this->lastModified . ($this->gzip ? '.gz' : '');

		if (is_file($cache_file) && is_readable($cache_file)) {
			$content = file_get_contents($cache_file);
		} else {
			$content = $this->getComposed();

			switch ($this->type) {
				case 'js':
					require_once 'jsmin.php';
					$content = JSMin::minify($content);
					if ($content[0] === "\n") $content = substr($content, 1);
					break;
				case 'css':
					$content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
					$content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
					break;
			}

			if ($this->gzip) $content = gzencode($content, 9, FORCE_GZIP);

			$fp = @fopen($cache_file, "wb");
			if ($fp) {
				fwrite($fp, $content);
				fclose($fp);
			}
		}

		return $content;
	}
}
?>