<?php

class NNPageSpeedChartWidget extends Contao\Widget
{
    /**
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * @param mixed $varInput
     * @return mixed
     */
    protected function validator($varInput)
    {
        return parent::validator($varInput);
    }

    /**
     * @return string
     */
    public function generate()
    {
		$thisID = \Input::get('id');

		$result .= '<div class="PagespeedChartContainer Mobile">';
		$result .= '	<canvas id="pagespeedChartMobile"></canvas>';
		$result .= '</div>';
		$result .= '<div class="PagespeedChartContainer Desktop">';
		$result .= '	<canvas id="pagespeedChartDesktop"></canvas>';
		$result .= '</div>';

		$result .= '<script>';
		$this->import("database");


		$data = $this->database->prepare("SELECT id, score, tstamp, strategy FROM tl_NNPageSpeedData WHERE pid=? ORDER BY tstamp DESC,strategy LIMIT 40")->execute( $thisID )->fetchAllAssoc();

		$result .= 'window.labelsData = [];';
		$result .= 'window.desktopData = [];';
		$result .= 'window.mobileData = [];';
		$desktopIndex = 0;
		$mobileIndex = 0;

		if ((is_array($data)) && (count($data) > 0))
		{
			$data = array_reverse($data);
			foreach ($data as $index => $theRow)
			{
				if ($theRow['strategy'] === 'desktop')
				{
					$result .= 'window.labelsData['.$desktopIndex.'] = "'.strftime("%d.%m.%Y",$theRow['tstamp']).'";';
					$result .= 'window.desktopData['.$desktopIndex++.'] = '.($theRow['score']*100).';';
				} else
				{
					$result .= 'window.mobileData['.$mobileIndex++.'] = '.($theRow['score']*100).';';
				}

			}
		}


		$result .= "function initChart(withTagID, andName, andData, andLabels)";
		$result .= "{";
		$result .= "	var context = document.getElementById(withTagID).getContext('2d');";
		$result .= "	return new Chart(context, {";
		$result .= "		type: 'line',";
		$result .= "";
		$result .= "";
		$result .= "		data: {";
		$result .= "			labels: andLabels,";
		$result .= "			datasets: [{";
		$result .= "				label: andName,";
		$result .= "				backgroundColor: 'rgba(245, 127, 5,0.5)',";
		$result .= "				borderColor: 'rgb(245, 127, 5)',";
		$result .= "				data: andData";
		$result .= "			}]";
		$result .= "		},";
		$result .= "";
		$result .= "		options:";
		$result .= "		{";
		$result .= "			maintainAspectRatio: false,";
		$result .= "			layout: {";
		$result .= "				padding: {";
		$result .= "					left: 50,";
		$result .= "					right: 50,";
		$result .= "					top: 0,";
		$result .= "					bottom: 0,";
		$result .= "				},";
		$result .= "				height: 90,";
		$result .= "";
		$result .= "			},";
		$result .= "			height: 90,";
		$result .= "		}";
		$result .= "	});";
		$result .= "}";
		$result .= "";


		$result .= "window.onload = function()";
		$result .= "{";
		$result .= "	window.mobileChart = initChart('pagespeedChartMobile', 'Mobile', mobileData, labelsData);";
		$result .= "	window.desktopChart = initChart('pagespeedChartDesktop', 'Desktop', desktopData, labelsData);";
		/*$result .= "";
		$result .= "	window.onStartProfiler = function onStartProfiler()";
		$result .= "	{";
		$result .= "";
		$result .= "		var theURL = document.getElementById('ctrl_url').value;";
		$result .= "		var tstamp = Math.trunc(new Date().getTime()/1000);";
		$result .= "";
		$result .= "";
		$result .= "		console.log('start > waiting for results for');";
		$result .= "";
		$result .= "		var url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='+theURL+'&strategy=mobile&screenshot=false';";
		$result .= "		fetch(url).then((response) =>";
		$result .= "		{";
		$result .= "			return response.json();";
		$result .= "		}).then((data) =>";
		$result .= "		{";
		$result .= "			theScore = data.lighthouseResult.categories.performance.score;";
		$result .= "			window.saveResult('mobile', theScore, theURL, data, tstamp);";
		$result .= "			console.log( theScore );";
		$result .= "";
		$result .= "			window.mobileChart.data.labels.push( tstamp );";
		$result .= "			window.mobileChart.data.datasets[0].data.push( theScore*100 );";
		$result .= "			window.mobileChart.update();";
		$result .= "		});";
		$result .= "";
		$result .= "		var url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='+theURL+'&strategy=desktop&screenshot=false';";
		$result .= "		fetch(url).then((response) =>";
		$result .= "		{";
		$result .= "			return response.json();";
		$result .= "		}).then((data) =>";
		$result .= "		{";
		$result .= "			theScore = data.lighthouseResult.categories.performance.score;";
		$result .= "			window.saveResult('desktop', theScore, theURL, data, tstamp);";
		$result .= "			console.log( theScore );";
		$result .= "			//window.desktopChart.data.labels.push( tstamp );";
		$result .= "			window.desktopChart.data.datasets[0].data.push( theScore*100 );";
		$result .= "			window.desktopChart.update();";
		$result .= "		});";
		$result .= "	}";
		$result .= "";
		$result .= "	window.saveResult = function(theStrategy, theScore, theURL, theResponse, theTimestamp)";
		$result .= "	{";
		$result .= "		theRequest = new XMLHttpRequest();";
		$result .= "		theRequestURL = 'system/modules/NNPagespeedProfiler/assets/dbinterface.php';";
		$result .= "		theRequest.open('POST', theRequestURL, true);";
		$result .= "		theRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');";
		$result .= "		theRequest.send('strategy='+theStrategy+'&score='+theScore+'&url='+theURL+'&response='+theResponse+'&tstamp='+theTimestamp+'&REQUEST_TOKEN=<?= RequestToken::get() ?>');";
		$result .= "	}";*/
		$result .= "}";




		$result .= '</script>';
		return  $result;

    }
}

?>
