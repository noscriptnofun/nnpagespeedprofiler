<?php
# @Author: andreasprietzel
# @Date:   1970-01-01T01:00:00+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:36:44+02:00

$GLOBALS['TL_DCA']['tl_NNPageSpeedProfilerWebsite'] = array
(
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => true,
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
		'onsubmit_callback' =>
		[
			['tl_NNPageSpeedProfilerWebsite', 'onSubmit']
		],
	),
	'list' => array
	(
		'sorting' => array
		(
			'fields'                  => array('name'),
			'headerFields'            => array('name'),
			'mode'                    => 5,
			'flag'                    => 11,
			'panelLayout'             => 'sort,filter;search,limit',
		),
		'label' => array
		(
			'fields'                  => array('name'),
			'format'                  => '%s',
			'label_callback' => array('tl_NNPageSpeedProfilerWebsite', 'labelCallback'),
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"',
			),
			/*'addSiteTree' => array
			(
				'label'               => 'Seitenstruktur übernehmen',
				'href'                => 'key=test',
				'class'               => 'header_new',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"',
				//'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'addSiteTree')
			)*/
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
				'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'editPage')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'deletePage')
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"',
				'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'copyPage')
			),
			'addSitestructure' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['addSitestructure'],
				'href'				  => 'key=onAddSiteStructureClicked',
				'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'addSitestructureButton')
			),
			'runPageSpeed' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['runPageSpeed'],
				'href'				  => 'key=runPageSpeed',
				'attributes'          => 'onclick="window.pageSpeedController.onRunSinglePageSpeedTestClick(%s,'."''".','."'".$GLOBALS['TL_LANGUAGE']."'".'); Backend.getScrollOffset();return false;"',
				'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'addRunPageSpeedButton')
			),
			'runPageSpeedAll' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['runPageSpeedAll'],
				'href'				  => 'key=runPageSpeedAll',
				//'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['runPageSpeedAllConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'attributes'          => 'onclick="window.pageSpeedController.onRunMultiPageSpeedTestClick(%s,'."''".','."'".$GLOBALS['TL_LANGUAGE']."'".'); Backend.getScrollOffset();return false;"',
				'button_callback'     => array('tl_NNPageSpeedProfilerWebsite', 'addRunPageSpeedAllButton')
			),
		),
	),
	'palettes' => array
	(
			'default'                     => '{group_settings},name,url,internalPage;{Google PageSpeed},apikey;{group_testresults},chart;{group_lastresults},responsemobile,responsedesktop',
	),
	'fields' => array
	(
		'id' => array
		(
			"sql"                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			"sql"                     => "int(10) unsigned NOT NULL"
		),
		'sorting' => array
		(
			"sql"                     => "int(10) unsigned NOT NULL"
		),
		'tstamp' => array
		(
			"sql"                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['url'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'fieldType'=>'radio', 'filesOnly'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'internalPage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['internalPage'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr', 'submitOnChange'=>true),
			'sql'                     => "blob NULL",
		),
		'apikey' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['apikey'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
		'chart' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['chart'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'pageSpeedChart',
			'eval'                    => array('tl_class'=>'clr'),
			'sql'                     => "int(10) unsigned NOT NULL DEFAULT 0",
		),
		'responsedesktop' => array
		(
			'label'                   => $GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['responsedesktop'],
			'exclude'                 => true,
			'search'                  => true,
			'eval'                    => array('tl_class'=>'RemoveStandardLabel'),
			'inputType'               => 'pageSpeedResult',
			'sql'                     => "LONGBLOB NULL"
		),
		'responsemobile' => array
		(
			'label'                   => $GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['responsemobile'],
			'exclude'                 => true,
			'search'                  => true,
			'eval'                    => array('tl_class'=>'RemoveStandardLabel'),
			'inputType'               => 'pageSpeedResult',
			'sql'                     => "LONGBLOB NULL"
		),

	)
);
class tl_NNPageSpeedProfilerWebsite extends Backend
{
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
		$this->import("database");
	}

	public function labelCallback($row, $label, DataContainer $dc=null, $imageAttribute='', $blnReturnImage=false, $blnProtected=false)
	{
		$id = $row['id'];
		$result = '<span';
		$scoreResult = '';

		$image = 'regular.gif';
		if (empty($row['pid']))
		{
			$image = 'root.gif';
		}
		$imageTag = '<img src="system/themes/flexible/images/'.$image.'" width="18" height="18" alt="" data-icon="'.$image.'"> ';

		$sqlResult = $this->database->prepare("SELECT `strategy`, `score`  FROM `tl_NNPageSpeedData` WHERE `pid`=? ORDER BY `tstamp` DESC, `strategy` ASC LIMIT 2")->execute( $id )->fetchAllAssoc();

		if (count($sqlResult))
		{
			$scoreResult = '(';
			foreach ($sqlResult as $theResult)
			{
				if (strlen($scoreResult)>1)
				{
					$scoreResult .= ' - ';
				}
				if ($theResult['strategy'] === 'desktop')
				{
					$scoreResult .= ' Desktop: '.$theResult['score']*100;
				} else
				{
					$scoreResult .= ' Mobile: '.$theResult['score']*100;
				}
			}
		}

		$childs = $this->database->prepare("SELECT `id`  FROM `tl_NNPageSpeedProfilerWebsite` WHERE `pid`=?")->execute( $id )->fetchAllAssoc();

		if ((!empty($row['pid'])) && (count($childs)===0))
		{
			$result .= ' style="padding-left:20px;"';
		}

		$result .= '>'.$imageTag;


		$result .= $row['name'];
		if (strlen($scoreResult))
		{
			$result .= ' '.$scoreResult.' )';
		}
		$result .= '<script>';
		$result .= 'window.pageSpeedWebsites['.$id.'] ={id:"'.$row['id'].'",url:"'.$row['url'].'",pid:'.$row['pid'].',apikey:"'.$row['apikey'].'"};';
		$result .= '</script>';
		$result .= '</span>';
		return $result;
	}

	public function onSubmit(DataContainer $dc)
	{
		$thisID = $dc->activeRecord->id;
		$thisInternalPage = $dc->activeRecord->internalPage;
		$newName = '';
		if (!empty($thisInternalPage))
		{
			$pageTitle = $this->database->prepare("SELECT `title` FROM `tl_page` WHERE `id`=?")->execute( $thisInternalPage )->fetchEach('title');
			if (count($pageTitle))
			{
				$newName = $pageTitle[0];
			}
		} else
		if ((!empty($dc->activeRecord->url)) && (empty($dc->activeRecord->name)))
		{
			$newName = $dc->activeRecord->url;
		}


		if (!empty($newName))
		{
			$this->database->prepare("UPDATE `tl_NNPageSpeedProfilerWebsite` SET `name`=? WHERE `id`=?")->execute( $newName, $thisID);
		}
	}

	/**
	 * Return the link picker wizard
	 *
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="' . (($dc->value == '' || strpos($dc->value, '{{link_url::') !== false) ? 'contao/page.php' : 'contao/file.php') . '?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . rawurlencode(str_replace(array('{{link_url::', '}}'), '', $dc->value)) . '&amp;switch=1' . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':768,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['label'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}


	public function addSitestructureButton($row, $href, $label, $title, $icon, $attributes)
	{
		$result = '';
		$sqlResult = $this->database->prepare("SELECT `id` FROM `tl_page` WHERE `pid`=?")->execute( $row['internalPage'] )->fetchAllAssoc();

		if (count($sqlResult))
		{
			$icon = 'system/modules/NNPagespeedProfiler/assets/addStructure.png';
			$buttonlabel = $GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['addSitestructure'][0];
			$result = '<a href="'.$this->addToUrl($href).'&id='.$row['id'].'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').' '.$buttonlabel.'</a>&nbsp;';
		}
		return $result;
	}

	public function addRunPageSpeedButton($row, $href, $label, $title, $icon, $attributes)
	{
		$type = $this->database->prepare("SELECT tl_page.type AS `type`, tl_NNPageSpeedProfilerWebsite.url AS `url` FROM `tl_NNPageSpeedProfilerWebsite`,`tl_page` WHERE tl_NNPageSpeedProfilerWebsite.pid = tl_page.id OR (tl_NNPageSpeedProfilerWebsite.id=? AND tl_NNPageSpeedProfilerWebsite.url != '')")->execute($row['id'])->fetchAllAssoc();;
		$result = '';
		if ((count($type)>0) && (($type['type'] !== 'root') || (trim(filter_var($type['url'], FILTER_VALIDATE_URL)))))
		{
			$icon = 'system/modules/NNPagespeedProfiler/assets/pagespeed.png';
			$buttonlabel = $GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['runPageSpeed']['0'];
			$result = '<a href="'.$this->addToUrl($href).'&id='.$row['id'].'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').' '.$buttonlabel.'</a>&nbsp';
		}
		return $result;
	}

	public function addRunPageSpeedAllButton($row, $href, $label, $title, $icon, $attributes)
	{
		$result = '';
		$sqlResult = $this->database->prepare("SELECT `id` FROM `tl_NNPageSpeedProfilerWebsite` WHERE `pid`=?")->execute( $row['id'] )->fetchAllAssoc();

		if (count($sqlResult))
		{
			$icon = 'system/modules/NNPagespeedProfiler/assets/pagespeed.png';
			$buttonlabel = $GLOBALS['TL_LANG']['tl_NNPageSpeedProfilerWebsite']['runPageSpeedAll']['0'];
			return '<a href="'.$this->addToUrl($href).'&id='.$row['id'].'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').' '.$buttonlabel.'</a>&nbsp';
		}
		return $result;
	}

	public function saveCallbackName($varValue, DataContainer $dc)
	{
		$dc->alias = StringUtil::generateAlias($varValue).'-'.$dc->id;
		return $varValue;
	}

	public function generateAlias($varValue, DataContainer $dc)
	{
		$varValue = StringUtil::generateAlias($dc->activeRecord->name).'-'.$dc->id;
		return $varValue;
	}


	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}
	}
	public function editPage($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_EDIT_PAGE, $row)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/.gif$/i', '_.gif', $icon)).' ';
	}
	public function copyPage($row, $href, $label, $title, $icon, $attributes, $table)
	{
		if ($GLOBALS['TL_DCA'][$table]['config']['closed'])
		{
			return '';
		}
		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_EDIT_PAGE_HIERARCHY, $row)) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/.gif$/i', '_.gif', $icon)).' ';
	}

	public function deletePage($row, $href, $label, $title, $icon, $attributes)
	{
		$root = func_get_arg(7);
		return ($this->User->hasAccess($row['type'], 'alpty') && $this->User->isAllowed(BackendUser::CAN_DELETE_PAGE, $row) && ($this->User->isAdmin || !in_array($row['id'], $root))) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/.gif$/i', '_.gif', $icon)).' ';
	}


}
?>
