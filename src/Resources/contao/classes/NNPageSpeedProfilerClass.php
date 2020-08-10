<?php
# @Author: andreasprietzel
# @Date:   2020-03-09T15:19:06+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:34:37+02:00

class NNPageSpeedProfilerClass extends Backend
{
	public function onAddSiteStructureClicked(\Contao\DC_Table $dc)
	{
		$this->import('database');
		$this->addSiteStructure($dc);
		\Contao\Controller::redirect('contao/main.php?do=PageSpeed%20Profiler');
	}

	private function addSiteStructure(\Contao\DC_Table $dc, $thisID = Null)
	{
		if ($thisID === Null)
		{
			$thisID = $dc->id;
		}

		\System::log('NNPagespeedProfilerClass.addSiteStructure($dc, thisID: '.$thisID.')' , __METHOD__, TL_GENERAL);

		$sqlSelect = 'SELECT tl_page.id as `pageID`, tl_page.title as `name`,tl_page.sorting as `sorting`, tl_page.alias as `alias`, tl_NNPageSpeedProfilerWebsite.apikey as `apikey`';
		$sqlFrom = 'FROM tl_NNPageSpeedProfilerWebsite, tl_page';
		$sqlWhere = 'WHERE tl_NNPageSpeedProfilerWebsite.id = ? AND tl_NNPageSpeedProfilerWebsite.internalPage = tl_page.pid AND tl_page.published=1';
		$sqlAdditional = 'ORDER BY tl_page.sorting';

		$subPagesSQLResult = $this->database->prepare("$sqlSelect $sqlFrom $sqlWhere $sqlAdditional")->execute( $thisID )->fetchAllAssoc();

		if ((is_array($subPagesSQLResult)) && (count($subPagesSQLResult) > 0))
		{//subPages gefunden:
			\System::log('Pages found: '.count($subPagesSQLResult), __METHOD__, TL_GENERAL);
			foreach ($subPagesSQLResult as $theSubPageSQLRow)
			{
				$sql = 'SELECT `id`, `internalPage` FROM `tl_NNPageSpeedProfilerWebsite` WHERE `internalPage`=? AND pid = ? ';
				$profileWebsiteItems = $this->database->prepare("$sql")->execute( $theSubPageSQLRow['pageID'], $thisID )->fetchAllAssoc();

				if ((is_array($profileWebsiteItems)) && (count($profileWebsiteItems) > 0))
				{//Eintrag existiert schon: update durchführen:
					$this->addSiteStructure($dc, $profileWebsiteItems[0]['id']);
				} else
				{//Eintrag existiert noch nicht: muss angelegt werden:
					$url = \Environment::get('url').'/'.$theSubPageSQLRow['alias'].'.html';
					$sqlValues = '`pid`, `internalPage`, `name`, `tstamp`, `sorting`, `url`, `apikey`';
					$sql = "INSERT INTO tl_NNPageSpeedProfilerWebsite ($sqlValues) VALUES (?, ?, ?, ?, ?, ?, ?)";
					$profileWebsiteID = $this->database->prepare("$sql")->execute( $thisID, $theSubPageSQLRow['pageID'], $theSubPageSQLRow['name'], time(), $theSubPageSQLRow['sorting'], $url, $theSubPageSQLRow['apikey'])->insertId;
					$this->addSiteStructure($dc, $profileWebsiteID);
				}
			}
		} else
		{//Keine subPage gefunden
			\System::log('NO PAGE FOUND!' , __METHOD__, TL_GENERAL);
		}
	}
}


?>
