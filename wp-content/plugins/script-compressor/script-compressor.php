<?php
/*
Plugin Name: Script Compressor
Plugin URI: http://rp.exadge.com/2008/04/30/script-compressor/
Description: This plugin compresses javascript files and css files.
Version: 1.7.1
Author: Regen
Author URI: http://rp.exadge.com
*/

/**
 * @author Regen
 * @copyright Copyright (C) 2009 Regen
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link http://rp.exadge.com/2008/04/30/script-compressor/ Script Compressor
 * @access public
 */

/**
 * Script Compressor main class.
 *
 */
class ScriptCompressor {
	/**
	 * Gettext domain.
	 *
	 * @var string
	 */
	var $domain;

	/**
	 * Pluguin name.
	 *
	 * @var string
	 */
	var $plugin_name;

	/**
	 * Path of this plugin.
	 *
	 * @var string
	 */
	var $plugin_path;

	/**
	 * Pluguin options.
	 *
	 * @var array
	 */
	var $options;

	/**
	 * Initialize ScriptCompressor.
	 *
	 */
	function ScriptCompressor() {
		$this->domain = 'script-compressor';
		$this->plugin_name = 'script-compressor';
		$this->option_page = 'sc_option_page';
		$this->output = '';
		if (defined('WP_PLUGIN_URL')) {
			$this->plugin_path = WP_PLUGIN_URL . '/' . $this->plugin_name;
			load_plugin_textdomain($this->domain, str_replace(ABSPATH, '', WP_PLUGIN_DIR) . '/' . $this->plugin_name);
		} else {
			$this->plugin_path = get_option('siteurl') . '/' . PLUGINDIR . '/'.$this->plugin_name;
			load_plugin_textdomain($this->domain, PLUGINDIR . '/' . $this->plugin_name);
		}

		add_action('admin_menu', array(&$this, 'regist_menu'));

		register_activation_hook(__FILE__, array(&$this, 'active'));
		register_deactivation_hook(__FILE__, array(&$this, 'deactive'));

		$this->get_option();

		$this->set_hooks();
	}

	/**
	 * Set WP hooks.
	 *
	 */
	function set_hooks() {
		if ($this->options['sc_comp']['auto_js_comp'] || ($this->options['sc_comp']['css_comp'] && $this->options['css_method'] == 'composed'))
			add_action('get_header', array(&$this, 'regist_header_comp'));
		else
			remove_action('get_header', array(&$this, 'regist_header_comp'));

		if ($this->options['output_footer'])
			add_action('wp_footer', array(&$this, 'output_footer'));
		else
			remove_action('wp_footer', array(&$this, 'output_footer'));

		if ($this->options['sc_comp']['css_comp'])
			add_filter('mod_rewrite_rules', array(&$this, 'rewrite_sc'));
		else
			remove_filter('mod_rewrite_rules', array(&$this, 'rewrite_sc'));
	}

	/**
	 * WP activation hook.
	 *
	 */
	function active() {
		global $wp_rewrite;

		$wp_rewrite->flush_rules();
	}

	/**
	 * WP deactivation hook.
	 *
	 */
	function deactive() {
		global $wp_rewrite;

		remove_action('get_header', array(&$this, 'regist_header_comp'));
		remove_filter('mod_rewrite_rules', array(&$this, 'rewrite_sc'));

		$wp_rewrite->flush_rules();
	}

	/**
	 * Get pluguin options.
	 *
	 */
	function get_option() {
		$this->options = (array)get_option('scriptcomp_option');

		/* {{{ Set default value */
		if (!isset($this->options['sc_comp'])) {
			$this->options['sc_comp'] = array();
			$this->options['sc_comp']['auto_js_comp'] = true;
			$this->options['sc_comp']['css_comp'] = true;
		} else if (!isset($this->options['sc_comp']['auto_js_comp'])) {
			$this->options['sc_comp']['auto_js_comp'] = false;
		} else if (!isset($this->options['sc_comp']['css_comp'])) {
			$this->options['sc_comp']['css_comp'] = false;
		}

		$this->options += array(
			'jspos' => array(),
			'exclude_js' => array(),
			'css_method' => 'respective',
			'gzip' => false,
			'output_footer' => false,
			'cache' => 'cache'
		);
		/* }}} */
	}

	/**
	 * Save pluguin options.
	 *
	 */
	function update_option() {
		update_option('scriptcomp_option', $this->options);
	}

	/**
	 * Delete pluguin options.
	 *
	 */
	function delete_option() {
		$this->options = array();
		delete_option('scriptcomp_option');
	}

	/**
	 * Start javascript compression.
	 *
	 */
	function comp_start() {
		ob_start(array(&$this, 'compress'));
	}

	/**
	 * End javascript compression.
	 *
	 */
	function comp_end() {
		ob_end_flush();
	}

	/**
	 * Compress content.
	 *
	 * @param string $content Compression target.
	 * @return string Compressed content.
	 */
	function compress($content) {
		$regex_js = '%<script.+src=["\'](?:(?!https?://)|(?:https?://' . preg_quote($_SERVER['HTTP_HOST'], '%') . '))/?(.+\.js(?:\?.*?)?)["\'].*>\s*</script>(?:\r?\n)*%m';
		$regex_css = '%<link.+href=["\'](?:(?!https?://)|(?:https?://' . preg_quote($_SERVER['HTTP_HOST'], '%') . '))/?(.+\.css(?:\?.*?)?)["\'].*/?>(?:\r?\n)*%m';

		$regex_before = $this->buildRegexFromArray($this->options['jspos']);
		$regex_exlude = $this->buildRegexFromArray($this->options['exclude_js']);

		$output_bef = '';
		$output_aft = '';
		$output_css = '';

		$shelve = $this->shelve('%<!--\[if .*\]>.+<!\[endif\]-->%s', $content);

		if (preg_match_all($regex_js, $content, $matches, PREG_SET_ORDER)) {
			$regex_remove = array();
			$befjs = $aftjs = array();
			foreach ($matches as $match) {
				$full = $match[0];
				$path = $match[1];
				if (!preg_match($regex_exlude, $path)) {
					if (preg_match($regex_before, $path)) {
						$befjs[] = $path;
					} else {
						$aftjs[] = $path;
					}
					$regex_remove[] = $full;
				}
			}

			$content = str_replace($regex_remove, '', $content);

			if (count($befjs) > 0) {
				$output_bef .= '<script type="text/javascript" src="' . $this->buildUrl($befjs) . '"></script>' . "\n";
			}
			if (count($aftjs) > 0) {
				$output_aft .= '<script type="text/javascript" src="' . $this->buildUrl($aftjs) . '"></script>' . "\n";
			}
		}
		if ($this->options['sc_comp']['css_comp'] && $this->options['css_method'] == 'composed') {
			if (preg_match_all($regex_css, $content, $matches)) {
				$cssfiles = $this->buildUrl($matches[1]);

				$content = preg_replace($regex_css, '', $content);

				$output_css .= '<link rel="stylesheet" href="' . $cssfiles . '" type="text/css" media="all" />' . "\n";
			}
		}

		if (preg_match('%<meta name="generator" content="WordPress.*" />%', $content, $matches)) {
			$content = str_replace($matches[0], $matches[0] . $output_bef, $content);
		} else {
			$content = $output_bef . $content;
		}

		$this->unshelve($shelve, $content);

		if ($this->options['output_footer']) {
			$this->output .= $output_aft;
			return $content . $output_css;
		} else {
			return $content . $output_css . $output_aft;
		}
	}

	/**
	 * Shelve strings which match pattern.
	 *
	 * @param string $pattern Preg pattern
	 * @param string $str Target strings
	 * @return array Shelved data
	 */
	function shelve($pattern, &$str) {
		$data = array();
		if (preg_match_all($pattern, $str, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$key = sprintf('__SHELVE_%s_%s__', count($data), time());
				$data[$key] = $match[0];
				$str = str_replace($match[0], $key, $str);
			}
		}
		return $data;
	}

	/**
	 * Unshelve strings which shelved.
	 *
	 * @param string $data Shelved data
	 * @param string $str Target strings
	 */
	function unshelve($data, &$str) {
		$str = str_replace(array_keys($data), array_values($data), $str);
	}

	/**
	 * Build Regex from array.
	 *
	 * @param array $targets
	 * @return string
	 */
	function buildRegexFromArray($targets) {
		if (count($targets) == 0) {
			return '/(?!)/';
		}
		
		$regex = array();
		foreach ($targets as $target) {
			if ($target !== '') {
				$regex[] = preg_quote($target, '/');
			}
		}
		
		$regex = '/' . implode('|', $regex) . '/i';
		return $regex;
	}

	/**
	 * Build URL to commpressed files.
	 *
	 * @param array|string $files
	 * @return string
	 */
	function buildUrl($files) {
		return $this->plugin_path . '/jscsscomp.php?q=' . implode(',', (array)$files);
	}

	/**
	 * Output scripts to footer.
	 */
	function output_footer() {
		echo $this->output;
	}

	/**
	 * Get script paths from URI.
	 *
	 * @return array Local script paths.
	 */
	function getScripts() {
		$files = explode(',', preg_replace('%.+/jscsscomp\.php\?q=%', '', $_SERVER['REQUEST_URI']));

		foreach ($files as $id => $file) {
			$file = rtrim($_SERVER['DOCUMENT_ROOT'], '\\/') . '/' . str_replace('..', '', $file);
			$files[$id] = $file;
		}

		return $files;
	}

	/**
	 * Regist auto header compression hooks.
	 *
	 */
	function regist_header_comp() {
		global $wp_filter;

		$this->comp_start();

		$max_priority = max(array_keys($wp_filter['wp_head'])) + 1;
		add_action('wp_head', array(&$this, 'comp_end'), $max_priority);
	}

	/**
	 * WP hook for rewrite.
	 *
	 * @param string $rewrite Rewrite data.
	 * @return string Rewrite data with rules of this pluguin.
	 */
	function rewrite_sc($rewrite) {
		$plugin_path_rewrite = preg_replace('%https?://' . preg_quote($_SERVER['HTTP_HOST'], '%') . '%', '', get_option('siteurl')) . '/wp-content/plugins/' . $this->plugin_name;
		$url = $plugin_path_rewrite . '/jscsscomp.php';
		$rule = '';

		$rule .= 'RewriteEngine on' . "\n";
		if (!empty($this->options['rewritecond'])) $rule .= $this->options['rewritecond'] . "\n";
		$rule .= 'RewriteRule ^(.*)\.css$ ' . $url . '?q=$1.css [NC,L]' . "\n";

		return $rule . $rewrite;
	}

	/**
	 * Regist this plugin to WP menu.
	 *
	 */
	function regist_menu() {
		add_options_page(__('Script Compressor Options', $this->domain), __('Script Compressor', $this->domain), 8, $this->option_page, array(&$this, 'sc_options_page'));
		add_filter('plugin_action_links', array(&$this, 'add_action_links'), 10, 2);
	}

	/**
	 * Add settings link to pluguin menu.
	 *
	 * @param array $links action links.
	 * @return array Links added settings link.
	 */
	function add_action_links($links, $file){
		if ($file == $this->plugin_name . '/' . basename(__FILE__)) {
			$settings_link = '<a href="options-general.php?page=' . $this->option_page . '">' . __('Settings', $this->domain) . '</a>';
			$links = array_merge(array($settings_link), $links);
		}
		return $links;
	}

	/**
	 * Pluguin option page.
	 *
	 */
	function sc_options_page() {
		global $wp_rewrite;

		$cache_dir = dirname(__FILE__) . '/' . $this->options['cache'];
		if (!is_writable($cache_dir)) {
			echo '<div class="error"><p>' . sprintf(__('Give the write permission to %s.', $this->domain), $cache_dir) . '</p></div>';
		}

		if (isset($_POST['action'])) {
			switch ($_POST['action']) {
				case 'update':
					$this->options['sc_comp'] = array();
					if (isset($_POST['sc_comp'])) {
						foreach ($_POST['sc_comp'] as $set) {
							$this->options['sc_comp'][$set] = true;
						}
					}
					$this->options['jspos'] = empty($_POST['jspos']) ? array() : explode("\n", str_replace(array("\r\n", "\n\n"), array("\n", ''), $_POST['jspos']));
					$this->options['exclude_js'] = empty($_POST['exclude_js']) ? array() : explode("\n", str_replace(array("\r\n", "\n\n"), array("\n", ''), $_POST['exclude_js']));
					$this->options['output_footer'] = isset($_POST['output_footer']);
					$this->options['css_method'] = $_POST['css_method'];
					$this->options['rewritecond'] = str_replace("\r\n", "\n", $_POST['rewritecond']);
					$this->options['gzip'] = isset($_POST['gzip']);

					$this->update_option();

					$this->set_hooks();

					$wp_rewrite->flush_rules();
					if (is_writable(get_home_path() . '.htaccess')) {
						echo '<div class="updated"><p><strong>' . __('Options saved.', $this->domain) . '</strong></p></div>';
					} else {
						echo '<div class="updated"><p><strong>' . __('Options saved.', $this->domain) . ' ' . __('Your .htaccess is not writable so you may need to re-save your <a href="options-permalink.php">permalink settings</a> manually.', $this->domain) . '</strong></p></div>';
					}
					break;
				case 'remove':
					$this->delete_option();
					$this->get_option();
					$this->set_hooks();

					$wp_rewrite->flush_rules();
					if (is_writable(get_home_path() . '.htaccess')) {
						echo '<div class="updated"><p><strong>' . __('Options removed.', $this->domain) . '</strong></p></div>';
					} else {
						echo '<div class="updated"><p><strong>' . __('Options removed.', $this->domain) . ' ' . __('Your .htaccess is not writable so you may need to re-save your <a href="options-permalink.php">permalink settings</a> manually.', $this->domain) . '</strong></p></div>';
					}
					break;
				case 'remove_cache':
					$count = 0;
					$size = 0;
					foreach (glob($cache_dir . '/*-*') as $file) {
						$filesize = filesize($file);
						if (unlink($file)) {
							$count++;
							$size += $filesize;
						}
					}
					echo '<div class="updated"><p><strong>' . sprintf(__ngettext('%d file removed (%d KB).', '%d files removed (%d KB).', $count, $this->domain), $count, $size / 1000) . '</strong></p></div>';
					break;
			}
		}

		$value = array();
		$checked = 'checked="checked" ';
		if (isset($this->options['sc_comp'])) {
			foreach ($this->options['sc_comp'] as $col => $whether) {
				$value[$col] = $whether ? $checked : '';
			}
		}
		switch ($this->options['css_method']) {
			case 'respective':
				$value['css_method']['respective'] = $checked;
				$value['css_method']['composed'] = '';
				break;
			case 'composed':
				$value['css_method']['respective'] = '';
				$value['css_method']['composed'] = $checked;
				break;
		}
		$value['jspos'] = implode("\n", $this->options['jspos']);
		$value['exclude_js'] = implode("\n", $this->options['exclude_js']);
		$value['gzip'] = $this->options['gzip'] ? $checked : '';
		$value['output_footer'] = $this->options['output_footer'] ? $checked : '';
		?>

<div class="wrap">
<h2><?php _e('Script Compressor Options', $this->domain) ?></h2>
<form action="?page=<?php echo $this->option_page ?>" method="post" id="sc_option">
<h3><?php _e('General Options', $this->domain) ?></h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><?php _e('Auto-compression', $this->domain) ?></th>
<td>
	<p>
		<label><input type="checkbox" name="sc_comp[]" value="auto_js_comp" <?php echo $value['auto_js_comp'] ?>/> <?php _e('Javascript compression in the header', $this->domain) ?></label>
	</p>
	<p>
		<label><input type="checkbox" name="sc_comp[]" value="css_comp" <?php echo $value['css_comp'] ?>/> <?php _e('CSS compression', $this->domain) ?></label>
	</p>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Gzip compression', $this->domain) ?></th>
<td>
	<p>
		<label><input type="checkbox" name="gzip" value="gzip" <?php echo $value['gzip'] ?>/> <?php _e('Use gzip compression for the cache and the output.', $this->domain) ?></label>
	</p>
</td>
</tr>
</tbody></table>
<h3><?php _e('Javascript Options', $this->domain) ?></h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><?php _e('Position of Javascripts', $this->domain) ?></th>
<td>
	<textarea class="code" rows="3" cols="40" wrap="off" name="jspos"><?php echo $value['jspos'] ?></textarea>
	<p><?php _e('This plugin will output compressed Javascripts after the header. However some scripts need to be loaded before other scripts. So you can input a part of script URL that need to be loaded first (one per line).', $this->domain) ?></p>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Exclude Javascripts', $this->domain) ?></th>
<td>
	<textarea class="code" rows="3" cols="40" wrap="off" name="exclude_js"><?php echo $value['exclude_js'] ?></textarea>
	<p><?php _e('You can input a part of script URL that need not to be compressed (one per line).', $this->domain) ?></p>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Output Position', $this->domain) ?></th>
<td>
	<p>
		<label><input type="checkbox" name="output_footer" value="output_footer" <?php echo $value['output_footer'] ?>/> <?php _e('Output compressed scripts to the footer.', $this->domain) ?></label>
	</p>
</td>
</tr>
</tbody></table>
<h3><?php _e('CSS Options', $this->domain) ?></h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><?php _e('CSS compression method', $this->domain) ?></th>
<td>
	<p>
		<label><input type="radio" name="css_method" value="respective" <?php echo $value['css_method']['respective'] ?>/> <?php _e('Respective', $this->domain) ?></label><br />
		<?php _e('This method compresses <strong>respective</strong> CSS files (former method). This uses .htaccess and mod_rewrite.', $this->domain) ?>
	</p>
	<p>
		<label><input type="radio" name="css_method" value="composed" <?php echo $value['css_method']['composed'] ?>/> <?php _e('Composed', $this->domain) ?></label><br />
		<?php _e('This method compresses <strong>composed</strong> CSS files in the header. The frequency of the HTTP request is less than "Respective" but there is a possibility that the paths of images in CSS files break and that the media type becomes ineffective.', $this->domain) ?>
	</p>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('CSS compression condition (mod_rewrite)', $this->domain) ?></th>
<td>
	<textarea class="code" rows="3" cols="40" wrap="off" name="rewritecond"><?php echo $this->options['rewritecond'] ?></textarea>
	<p><?php _e('This text is inserted in the upper part of RewriteRule added by this plugin in your .htaccess. Please see <a href="http://httpd.apache.org/docs/2.0/mod/mod_rewrite.html#rewritecond">RewriteCond doc</a>.', $this->domain) ?></p>
	<p><?php _e('Example: <code>RewriteCond %{REQUEST_URI} !.*wp-admin.*</code>', $this->domain) ?></p>
</td>
</tr>
</tbody></table>
<p class="submit">
<input type="hidden" name="action" value="update" />
<input type="submit" class="button-primary" value="<?php _e('Update Options', $this->domain) ?>" name="submit"/>
</p>
</form>
<br />
<h2><?php _e('Instructions', $this->domain) ?></h2>
<h3><?php _e('Additional template tags', $this->domain) ?></h3>
<p><?php _e('Javascripts and CSS between <code>&lt;?php sc_comp_start() ?&gt;</code> and <code>&lt;?php sc_comp_end() ?&gt;</code> will be compressed by this plugin.', $this->domain) ?></p>
<p><?php _e('e.g.', $this->domain) ?><br /><code style="display: block; padding: 6px; background-color: #eeeeee; border: #dfdfdf solid 1px;"><?php _e('&lt;?php sc_comp_start() ?&gt;<br />&lt;script type="text/javascript" src="foo.js"&gt;&lt;/script&gt;<br />&lt;script type="text/javascript" src="bar.js"&gt;&lt;/script&gt;<br />&lt;?php sc_comp_end() ?&gt;', $this->domain) ?></code></p>
<p><?php _e('If you check "Javascript compression in the header", the scripts in the header will be compressed automatically.', $this->domain) ?></p>
<h2><?php _e('Notes', $this->domain) ?></h2>
<ul>
<li><?php _e('This plugin makes caches in the compression progress.', $this->domain) ?></li>
<li><?php _e('Only files located in the same server as your WordPress can be compressed.', $this->domain) ?></li>
<li><?php _e('The extensions of Javascript and CSS should be .js and .css respectively.', $this->domain) ?></li>
<li><?php _e('<strong>When you deactivate this plugin, the mod_rewrite codes in the .htaccess can remain and cause problems, so you may need to re-save your <a href="options-permalink.php">permalink settings</a> after the deactivation.</strong>', $this->domain) ?></li>
</ul>
<br />
<h2><?php _e('Remove cache files', $this->domain) ?></h2>
<p><?php _e('You can remove the cache files.', $this->domain) ?></p>
<form action="?page=<?php echo $this->option_page ?>" method="post">
<p>
<input type="hidden" name="action" value="remove_cache" />
<input type="submit" class="button" value="<?php _e('Remove cache files', $this->domain) ?>" name="submit" />
</p>
</form>
<br />
<h2><?php _e('Remove options', $this->domain) ?></h2>
<p><?php _e('You can remove the above options from the database.', $this->domain) ?></p>
<form action="?page=<?php echo $this->option_page ?>" method="post">
<p>
<input type="hidden" name="action" value="remove" />
<input type="submit" class="button" value="<?php _e('Remove options', $this->domain) ?>" name="submit" />
</p>
</form>
</div>

		<?php
	}
}

$scriptcomp = &new ScriptCompressor();

/**
 * Start javascript compression.
 */
function sc_comp_start() {
	global $scriptcomp;

	$scriptcomp->comp_start();
}

/**
 * End javascript compression.
 */
function sc_comp_end() {
	global $scriptcomp;

	$scriptcomp->comp_end();
}