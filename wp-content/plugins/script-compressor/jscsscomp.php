<?php
if (file_exists('../../../wp-load.php')){
	require_once '../../../wp-load.php';
} else {
	require_once '../../../wp-config.php';
}

require_once 'comp.class.php';

$comp = new Compressor(array(
	'files' => $scriptcomp->getScripts(),
	'charset' => get_option('blog_charset'),
	'gzip' => $scriptcomp->options['gzip'],
	'replacePath' => $scriptcomp->options['css_method'] == 'composed',
	'cache' => $scriptcomp->options['cache'],
	'importCallback' => array($scriptcomp, 'buildUrl')
));
$comp->sendHeader();
echo $comp->getContent();