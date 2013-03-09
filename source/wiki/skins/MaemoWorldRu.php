<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

require_once( dirname( dirname( __FILE__ ) ) . '/includes/SkinTemplate.php');

if (!defined('PATHS_SEPARATOR')): // если не определен разделитель путей
	define('PATHS_SEPARATOR', getenv('COMSPEC') ? ';' : ':'); // если винда, то ';', линукс - ':'
endif;
ini_set('include_path', ini_get('include_path').PATHS_SEPARATOR.'..'.PATHS_SEPARATOR.'../content'.PATHS_SEPARATOR.'../include'); // добавляем каталоги 'include' и 'content'

global $config, $data;
require_once 'config.php'; // найтройки 
$config['templates']['dir'] = '../include/templates/';
require_once 'lib/punbb.php'; // работа с punbb


/**
 * MaemoWorld.ru
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */
class SkinMaemoWorldRu extends SkinTemplate {
	/** Using monobook. */
	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'MaemoWorldRu';
		$this->stylename = 'MaemoWorldRu';
		$this->template  = 'MaemoWorldRuTemplate';
	}

	function setupSkinUserCss( OutputPage $out ) {
	}
}

/**
 * @todo document
 * @ingroup Skins
 */
class MaemoWorldRuTemplate extends QuickTemplate {
	var $skin;
	/**
	 * Template filter callback for MaemoWorldRu skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgRequest;
		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		/*
			Начинаем дела MaemoWorld.ru
		*/
		
		General::$data['wiki'] = $this->data;

		switch (General::getContentType()) { // в зависимости от типа запрашиваемых данных
		case 'json':
			echo json_encode($data['wiki']); // вывести результат
			exit;
		case 'html':
		default:
			General::$data['wiki']['skin'] = $this->skin;
			General::$data['page']['powered_by'] = '<a href="http://www.mediawiki.org/">MediaWiki</a>';
			if (!is_null(General::$data['page']['breadcrumbs'])) { // если рассыпаются хлебные крошки
				General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
					'name' => 'База знаний',
					'link' => wiki_url(false)
				);
				General::$data['page']['breadcrumbs'][] = array ( // новая хлебная крошка
					'name' => $this->data['pagetitle'],
					'link' => page_url(false)
				);
			}
			Template::addPageHeadExtra($this->data['csslinks']); // ссылки на css
			Template::addPageHeadExtra($this->data['headlinks']);
			Template::addPageHeadExtra('		<!--[if lt IE 7]><script type="'.htmlspecialchars($this->data['jsmimetype']).'" src="'.htmlspecialchars($this->data['stylepath']).'/common/IEFixes.js?'.$GLOBALS['wgStyleVersion'].'"></script><meta http-equiv="imagetoolbar" content="no" /><![endif]-->'."\n");
			Template::addPageHeadExtra(Skin::makeGlobalVariablesScript($this->data));
			Template::addPageHeadExtra('		<script type="'.htmlspecialchars($this->data['jsmimetype']).'" src="'.htmlspecialchars($this->data['stylepath']).'/common/wikibits.js?'.$GLOBALS['wgStyleVersion'].'"><!-- wikibits js --></script>'."\n");
			Template::addPageHeadExtra('		<!-- Head Scripts -->'."\n");
			Template::addPageHeadExtra($this->data['headscripts']);
			if($this->data['jsvarurl']) {
				Template::addPageHeadExtra('		<script type="'.htmlspecialchars($this->data['jsmimetype']).'" src="'.htmlspecialchars($this->data['jsvarurl']).'"><!-- site js --></script>'."\n");
			}
			if($this->data['pagecss']) {
				Template::addPageHeadExtra('		<style type="text/css">'.$this->data['pagecss'].'</style>'."\n");
			}
			if($this->data['usercss']) {
				Template::addPageHeadExtra('		<style type="text/css">'.$this->data['usercss'].'</style>'."\n");
			}
			if($this->data['userjs']) {
				Template::addPageHeadExtra('		<script type="'.htmlspecialchars($this->data['jsmimetype']).'" src="'.htmlspecialchars($this->data['userjs']).'"></script>'."\n");
			}
			if($this->data['userjsprev']) {
				Template::addPageHeadExtra('		<script type="'.htmlspecialchars($this->data['jsmimetype']).'">'.$this->data['userjsprev'].'</script>'."\n");
			}
			if($this->data['trackbackhtml']) {
				Template::addPageHeadExtra($this->data['trackbackhtml']);
			}
//			templates::$pageAddToFooter .= $this->data['bottomscripts'];						
//			$this->html('reporttime'); // время генерации
//			if ( $this->data['debug'] ){
//				echo '<!-- Debug output:'."\n";
//				$this->text( 'debug' );
//				echo '-->';
//			}
//			wfRestoreWarnings();
			Template::generatePage('mediawiki'); // сгенерировать страницу
			exit;
		}
	} // end of execute() method


	/*************************************************************************************************/
	function customBox( $bar, $cont ) {
		$sidebox_id = Sanitizer::escapeId('p-'.$bar); // + '"' + $this->skin->tooltip('p-'.$bar);
		$out = wfMsg( $bar );
		if (wfEmptyMsg($bar, $out))
			$sidebox_name = $bar;
		else
			$sidebox_name = $out;
		ob_start();
?>			<? if (is_array($cont)) { ?>
				<ul>
					<? foreach($cont as $key => $val) { ?>
						<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<? $val['active'] ? the('class="active"') : the('') ?>>
							<a href="<? the(htmlspecialchars($val['href'])) ?>"<? the($this->skin->tooltipAndAccesskey($val['id'])) ?>><? the(htmlspecialchars($val['text'])) ?></a>
						</li>
					<? } ?>
				</ul>
			<? } else { ?>
				<? the($cont) ?>
			<? } ?>
<?php
		$sidebox_body = ob_get_clean();
		page_sidebox($sidebox_name, $sidebox_body, 'nav', array('id' => $sidebox_id));
	}
}
