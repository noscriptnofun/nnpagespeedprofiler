<?php
# @Author: andreasprietzel
# @Date:   2020-02-29T16:27:40+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:35:03+02:00

ClassLoader::addClasses(array
(
	'NNPageSpeedProfilerClass' => 'system/modules/NNPagespeedProfiler/classes/NNPageSpeedProfilerClass.php',
	'NNPageSpeedChartWidget'   => 'system/modules/NNPagespeedProfiler/widgets/NNPageSpeedChartWidget.php',
	'NNPageSpeedResultWidget'  => 'system/modules/NNPagespeedProfiler/widgets/NNPageSpeedResultWidget.php',
));

TemplateLoader::addFiles(array
(
	'mod_pagespeedprofiler_be_stat' => 'system/modules/NNPagespeedProfiler/templates',
));
