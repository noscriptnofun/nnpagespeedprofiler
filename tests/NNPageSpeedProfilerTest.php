<?php

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace nsnf\NNPageSpeedProfiler\Tests;

use nsnf\NNPageSpeedProfiler\NNPageSpeedProfilerBundle;
use PHPUnit\Framework\TestCase;

class NNPageSpeedProfilerTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new NNPageSpeedProfilerBundle();

        $this->assertInstanceOf('nsnf\NNPageSpeedProfiler\NNPageSpeedProfilerBundle', $bundle);
    }
}
