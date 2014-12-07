<?php
/**
 * RandomColor 1.0.0
 *
 * PHP port of David Merfield JavaScript randomColor
 * https://github.com/davidmerfield/randomColor
 *
 *
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 Damien "Mistic" Sorel
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

class RandomColor
{
  static private $dictionary = null;

  private function __construct() {}

  static public function one($options = array())
  {
    self::_loadDictionary();

    $h = self::_pickHue($options);
    $s = self::_pickSaturation($h, $options);
    $v = self::_pickBrightness($h, $s, $options);

    return self::format(compact('h','s','v'), @$options['format']);
  }

  static public function many($count, $options = array())
  {
    $colors = array();

    for ($i = 0; $i < $count; $i++)
    {
      $colors[] = self::one($options);
    }

    return $colors;
  }

  static public function format($hsv, $format='hex')
  {
    switch ($format)
    {
      case 'hsv':
        return $hsv;
        
      case 'hsl':
        return self::hsv2hsl($hsv);

      case 'hslCss':
        $hsl = self::hsv2hsl($hsv);
        return 'hsl(' . $hsl['h'] . ',' . $hsl['s'] . '%,' . $hsl['l'] . '%)';

      case 'rgb':
        return self::hsv2rgb($hsv);

      case 'rgbCss':
        return 'rgb(' . implode(',', self::hsv2rgb($hsv)) . ')';

      case 'hex':
      default:
        return self::hsv2hex($hsv);
    }
  }

  static private function _pickHue($options)
  {
    $range = self::_getHueRange($options);

    if ($range === null)
    {
      return 0;
    }

    $hue = mt_rand($range[0], $range[1]);

    // Instead of storing red as two seperate ranges,
    // we group them, using negative numbers
    if ($hue < 0)
    {
      $hue = 360 + $hue;
    }

    return $hue;
  }

  static private function _pickSaturation($h, $options)
  {
    if (@$options['luminosity'] === 'random')
    {
      return mt_rand(0, 100);
    }
    if (@$options['hue'] === 'monochrome')
    {
      return 0;
    }

    $colorInfo = self::_getColorInfo($h);
    $range = $colorInfo['saturationRange'];

    switch (@$options['luminosity'])
    {
      case 'bright':
        $range[0] = 55;
        break;

      case 'dark':
        $range[0] = $range[1] - 10;
        break;

      case 'light':
        $range[1] = 55;
        break;
    }

    return mt_rand($range[0], $range[1]);
  }

  static private function _pickBrightness($h, $s, $options)
  {
    if (@$options['luminosity'] === 'random')
    {
      $range = array(0, 100);
    }
    else
    {
      $range = array(
        self::_getMinimumBrightness($h, $s),
        100
        );

      switch (@$options['luminosity'])
      {
        case 'dark':
          $range[1] = $range[0] + 20;
          break;

        case 'light':
          $range[0] = ($range[1] + $range[0]) / 2;
          break;
      }
    }

    return mt_rand($range[0], $range[1]);
  }

  static private function _getHueRange($options)
  {
    if (isset($options['hue']))
    {
      if (isset(self::$dictionary[$options['hue']]))
      {
        return self::$dictionary[$options['hue']]['hueRange'];
      }
      else if (is_numeric($options['hue']))
      {
        $hue = intval($options['hue']);

        if ($hue < 360 && $hue >= 0)
        {
          return array($hue, $hue);
        }
      }
    }

    return array(0, 360);
  }

  static private function _getMinimumBrightness($h, $s)
  {
    $colorInfo = self::_getColorInfo($h);
    $bounds = $colorInfo['lowerBounds'];

    for ($i = 0, $l = count($bounds); $i < $l - 1; $i++)
    {
      $s1 = $bounds[$i][0];
      $v1 = $bounds[$i][1];
      $s2 = $bounds[$i+1][0];
      $v2 = $bounds[$i+1][1];

      if ($s >= $s1 && $s <= $s2)
      {
        $m = ($v2 - $v1) / ($s2 - $s1);
        $b = $v1 - $m * $s1;
        return $m * $s + $b;
      }
    }

    return 0;
  }

  static private function _getColorInfo($h)
  {
    // Maps red colors to make picking hue easier
    if ($h >= 334 && $h <= 360)
    {
      $h-= 360;
    }

    foreach (self::$dictionary as $color)
    {
      if ($color['hueRange'] !== null && $h >= $color['hueRange'][0] && $h <= $color['hueRange'][1])
      {
        return $color;
      }
    }
  }

  static public function hsv2hex($hsv)
  {
    $rgb = self::hsv2rgb($hsv);
    $hex = '#';

    foreach ($rgb as $c)
    {
      $hex.= str_pad(dechex($c), 2, '0', STR_PAD_LEFT);
    }

    return $hex;
  }
  
  static public function hsv2hsl($hsv)
  {
    extract($hsv);
    
    $s/= 100;
    $v/= 100;
    $k = (2-$s)*$v;
    
    return array(
      'h' => $h,
      's' => round($s*$v / ($k < 1 ? $k : 2-$k), 4) * 100,
      'l' => $k/2 * 100,
      );
  }

  static public function hsv2rgb($hsv)
  {
    extract($hsv);

    $h/= 360;
    $s/= 100;
    $v/= 100;

    $i = floor($h * 6);
    $f = $h * 6 - $i;

    $m = $v * (1 - $s);
    $n = $v * (1 - $s * $f);
    $k = $v * (1 - $s * (1 - $f));

    $r = 1;
    $g = 1;
    $b = 1;

    switch ($i)
    {
      case 0:
        list($r,$g,$b) = array($v,$k,$m);
        break;
      case 1:
        list($r,$g,$b) = array($n,$v,$m);
        break;
      case 2:
        list($r,$g,$b) = array($m,$v,$k);
        break;
      case 3:
        list($r,$g,$b) = array($m,$n,$v);
        break;
      case 4:
        list($r,$g,$b) = array($k,$m,$v);
        break;
      case 5:
      case 6:
        list($r,$g,$b) = array($v,$m,$n);
        break;
    }
    
    return array(
      'r' => floor($r*255),
      'g' => floor($g*255),
      'b' => floor($b*255),
      );
  }

  static private function _loadDictionary()
  {
    if (!empty(self::$dictionary))
    {
      return;
    }

    self::$dictionary = array(
      'monochrome' => array(
        'hueRange' => 'null',
        'lowerBounds' => '[[0,0],[100,0]]',
        ),
      'red' => array(
        'hueRange' => '[-26,18]',
        'lowerBounds' => '[[20,100],[30,92],[40,89],[50,85],[60,78],[70,70],[80,60],[90,55],[100,50]]',
        ),
      'orange' => array(
        'hueRange' => '[19,46]',
        'lowerBounds' => '[[20,100],[30,93],[40,88],[50,86],[60,85],[70,70],[100,70]]',
        ),
      'yellow' => array(
        'hueRange' => '[47,62]',
        'lowerBounds' => '[[25,100],[40,94],[50,89],[60,86],[70,84],[80,82],[90,80],[100,75]]',
        ),
      'green' => array(
        'hueRange' => '[63,178]',
        'lowerBounds' => '[[30,100],[40,90],[50,85],[60,81],[70,74],[80,64],[90,50],[100,40]]',
        ),
      'blue' => array(
        'hueRange' => '[179, 257]',
        'lowerBounds' => '[[20,100],[30,86],[40,80],[50,74],[60,60],[70,52],[80,44],[90,39],[100,35]]',
        ),
      'purple' => array(
        'hueRange' => '[258, 282]',
        'lowerBounds' => '[[20,100],[30,87],[40,79],[50,70],[60,65],[70,59],[80,52],[90,45],[100,42]]',
        ),
      'pink' => array(
        'hueRange' => '[283, 334]',
        'lowerBounds' => '[[20,100],[30,90],[40,86],[60,84],[80,80],[90,75],[100,73]]',
        ),
      );

    foreach (self::$dictionary as &$color)
    {
      $color['hueRange'] = json_decode($color['hueRange'], true);
      $color['lowerBounds'] = json_decode($color['lowerBounds'], true);

      $color['saturationRange'] = array(
        $color['lowerBounds'][0][0],
        $color['lowerBounds'][count($color['lowerBounds'])-1][0],
        );

      $color['brightnessRange'] = array(
        $color['lowerBounds'][count($color['lowerBounds'])-1][1],
        $color['lowerBounds'][0][1],
        );
    }
    unset($color);
  }
}