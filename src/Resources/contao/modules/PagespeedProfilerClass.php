<?php
# @Author: andreasprietzel
# @Date:   2020-02-29T15:16:06+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:37:54+02:00

namespace NSNF\PagespeedProfiler;

class PagespeedProfilerClass extends \BackendModule
{
	protected $strTemplate = 'mod_pagespeedprofiler_be_stat';

	public function __construct()
	{
	    $this->import('BackendUser', 'User');
	    parent::__construct();
	}

	protected function compile()
	{
		return 'test';
	}

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate($strTemplate);
			$objTemplate->wildcard = '';
			$objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			//return $objTemplate->parse();
			return  parent::generate();;
		}
	}

	protected function generateExport()
	{
		return '';
	}

}
