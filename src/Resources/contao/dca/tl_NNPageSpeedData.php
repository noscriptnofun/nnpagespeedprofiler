<?php

$GLOBALS['TL_DCA']['tl_NNPageSpeedData'] = array
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
	),
	'list' => array
	(
		'sorting' => array
		(
			'fields'                  => array('tstamp'),
			'mode'                    => 1,
			'flag'                    => 11,
			'panelLayout'             => 'sort,filter;search,limit',
		),
		'label' => array
		(
			'fields'                  => array('tstamp'),
			'format'                  => '%s',
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_page']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_page']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_page']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"',
			),
		),
	),
	'palettes' => array
	(
			'default'                     => 'tstamp,score,strategy',
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
		'tstamp' => array
		(
			"sql"                     => "int(10) unsigned NOT NULL default '0'"
		),
		'score' => array
		(
			'label'                   => ['Wertung (0 - 100)'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'sql'                     => "float unsigned NOT NULL default '0'",
		),
		'strategy' => array
		(
			'label'                   => ['Desktop oder Mobile'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'sql'                     => "varchar(255) NOT NULL default ''",
		),
	)
);

class tl_NNPageSpeedData extends Backend
{
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
}
?>
