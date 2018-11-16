<?php

namespace Colors\Tests;

use Colors\RandomColor;
use PHPUnit\Framework\TestCase;

class RandomColorTest extends TestCase
{
    public function testOneShouldReturnRandomColor()
    {
        $hexColor = RandomColor::one();

        $this->assertContains('#', $hexColor);
        $this->assertSame(7, strlen($hexColor));
        $this->assertRegExp('/#\w{6}/', $hexColor);
    }

    public function testManyShouldReturnTenGreenColors()
    {
        $hexColors = RandomColor::many(10, [
            'hue' => 'green',
        ]);

        $this->assertCount(10, $hexColors);
        foreach ($hexColors as $hexColor) {
            $this->assertContains('#', $hexColor);
            $this->assertSame(7, strlen($hexColor));
            $this->assertRegExp('/#\w{6}/', $hexColor);
        }
    }

    public function testOneShouldReturnRandomLightBlueColor()
    {
        $hexColor = RandomColor::one([
            'luminosity' => 'light',
            'hue' => 'blue',
        ]);

        $this->assertContains('#', $hexColor);
        $this->assertSame(7, strlen($hexColor));
        $this->assertRegExp('/#\w{6}/', $hexColor);
    }

    public function testOneShouldReturnRandomLightBlueOrYellowColor()
    {
        $hexColor = RandomColor::one([
            'hue' => ['yellow', 'blue'],
        ]);

        $this->assertContains('#', $hexColor);
        $this->assertSame(7, strlen($hexColor));
        $this->assertRegExp('/#\w{6}/', $hexColor);
    }

    public function testOneShouldReturnTrulyRandomColor()
    {
        $hexColor = RandomColor::one([
            'luminosity' => 'random',
            'hue' => 'random',
        ]);

        $this->assertContains('#', $hexColor);
        $this->assertSame(7, strlen($hexColor));
        $this->assertRegExp('/#\w{6}/', $hexColor);
    }

    public function testOneShouldReturnRandomBrightRgbColor()
    {
        $hexColor = RandomColor::one([
            'luminosity' => 'bright',
            'format' => 'rgbCss',
        ]);

        $this->assertContains('rgb(', $hexColor);
        $this->assertContains(')', $hexColor);
        $this->assertContains(',', $hexColor);
        $this->assertRegExp('/rgb\( *(\d{1,3} *, *\d{1,3} *, *\d{1,3}) *\)/i', $hexColor);
    }
}
