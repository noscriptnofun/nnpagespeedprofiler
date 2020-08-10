<?php
# @Author: andreasprietzel
# @Date:   1970-01-01T01:00:00+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:35:52+02:00

namespace nsnf\NNPageSpeedProfiler;

use Symfony\Component\HttpFoundation\Response;


class ContaoBackendController extends \Backend
{
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct();

		$this->User->authenticate();

		\System::loadLanguageFile('default');

	}

	/**
	 * Run the controller and parse the template
	 *
	 * @return Response
	 */
	public function run()
	{

		$theStrategy = \Input::POST('strategy');
		$theScore    = \Input::POST('score');
		$thePID      = \Input::POST('id');
		$theResponse = \Input::POST('response');
		$theTimestamp = \Input::POST('timestamp');

		if (!empty($thePID))
		{
			$this->import("database");

			$this->Input->post('email');


			$this->database->prepare("INSERT INTO `tl_NNPageSpeedData` (`strategy`, `score`, `pid`, `tstamp`) VALUES (?, ?, ?, ?)")->execute($theStrategy, $theScore, $thePID, $theTimestamp);
			$this->database->prepare("UPDATE `tl_NNPageSpeedProfilerWebsite` SET `response".$theStrategy."`=? WHERE `id`=?")->execute($theResponse, $thePID);
		}

		$objTemplate = new \BackendTemplate('be_wildcard');
		$objTemplate->wildcard = '### ContaoBackendController ###';
		$objTemplate->title    = $this->headline;
		$objTemplate->id       = $this->id;

		return $objTemplate->getResponse();
	}
}
