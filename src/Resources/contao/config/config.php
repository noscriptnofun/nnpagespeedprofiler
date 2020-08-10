<?php

$GLOBALS['BE_MOD']['system']['PageSpeed Profiler'] = array
(
	'tables' => ['tl_NNPageSpeedProfilerWebsite'],
	'stylesheet' => [
						'bundles/nnpagespeedprofiler/Chart.min.css',
						'bundles/nnpagespeedprofiler/main.css',
						'bundles/nnpagespeedprofiler/anychart/anychart-ui.min.css',
						'bundles/nnpagespeedprofiler/anychart/anychart-font.min.css',
						'bundles/nnpagespeedprofiler/colorbox/css/colorbox.min.css',
					],
	'javascript' => [
						'bundles/nnpagespeedprofiler/Chart.min.js',
						'bundles/nnpagespeedprofiler/anychart/anychart-base.min.js',
						'bundles/nnpagespeedprofiler/anychart/anychart-ui.min.js',
						'bundles/nnpagespeedprofiler/anychart/anychart-table.min.js',
						'bundles/nnpagespeedprofiler/anychart/light_blue.min.js',
						'bundles/nnpagespeedprofiler/jquery/jquery.min.js',
						'bundles/nnpagespeedprofiler/colorbox/js/colorbox.min.js',
						'bundles/nnpagespeedprofiler/NNPageSpeedController.js',
					],
);

$GLOBALS['BE_FFL']['pageSpeedChart'] = 'NNPageSpeedChartWidget';
$GLOBALS['BE_FFL']['pageSpeedResult'] = 'NNPageSpeedResultWidget';
$GLOBALS["BE_MOD"]["system"]["PageSpeed Profiler"]['onAddSiteStructureClicked'] = array('NNPageSpeedProfilerClass', 'onAddSiteStructureClicked');
$GLOBALS["BE_MOD"]["system"]["PageSpeed Profiler"]['addSiteStructure'] = array('NNPageSpeedProfilerClass', 'addSiteStructure');
$GLOBALS["BE_MOD"]["system"]["PageSpeed Profiler"]['runPageSpeed'] = array('NNPageSpeedProfilerClass', 'runPageSpeed');
$GLOBALS["BE_MOD"]["system"]["PageSpeed Profiler"]['runPageSpeedAll'] = array('NNPageSpeedProfilerClass', 'runPageSpeedAll');
?>
