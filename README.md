# Random Color

[![PHP version](https://badge.fury.io/ph/mistic100%2Frandomcolor.svg)](http://badge.fury.io/ph/mistic100%2Frandomcolor)

For generating attractive random colors. 

This is a PHP port of David Merfield [randomColor](https://github.com/davidmerfield/randomColor) Javascript utility.

See the results on [the demo](http://www.strangeplanet.fr/work/RandomColor.php).

[![Demo](https://raw.githubusercontent.com/mistic100/RandomColor.php/master/demo/screenshot.jpg)](http://www.strangeplanet.fr/work/RandomColor.php)

### Options

You can pass an options object to influence the type of color it produces. The options object accepts the following properties:

**hue** – Controls the hue of the generated color. You can pass a string representing a color name (e.g. 'orange'). Possible color names are *red, orange, yellow, green, blue, purple, pink and monochrome*. You can also pass an array of multiple hues or a specific hue (0 to 360).

**luminosity** – Controls the luminosity of the generated color. You can pass a string containing *bright, light or dark*.

**format** – A string which specifies the format of the generated color. Possible values are *hsv, hsl, hslCss, rgb, rgbCss, and hex*.

**prng** – A random (or not) number generator. `mt_rand` is used as default one.

### Examples

```php

use \Colors\RandomColor;

// Returns a hex code for an attractive color
RandomColor::one(); 

// Returns an array of ten green colors
RandomColor::many(10, array(
   'hue' => 'green'
));

// Returns a hex code for a light blue
RandomColor::one(array(
   'luminosity' => 'light',
   'hue' => 'blue'
));

// Returns one yellow or blue color
RandomColors::one(array(
    'hue' => array('yellow', 'blue')
));

// Returns a hex code for a 'truly random' color
RandomColor::one(array(
   'luminosity' => 'random',
   'hue' => 'random'
));

// Returns a bright color in RGB
RandomColor::one(array(
   'luminosity' => 'bright',
   'format' => 'rgbCss' // e.g. 'rgb(225,200,20)'
));
```

### Other languages

RandomColor is available in [JavaScript](https://github.com/davidmerfield/randomColor), [C#](https://github.com/nathanpjones/randomColorSharped), [C++](https://github.com/xuboying/randomcolor-cpp), [Go](https://github.com/hansrodtang/randomcolor), [Python](https://github.com/kevinwuhoo/randomcolor-py), [Swift](https://github.com/onevcat/RandomColorSwift), [Objective-C](https://github.com/yageek/randomColor), [Java](https://github.com/lzyzsd/AndroidRandomColor), [R](https://github.com/ronammar/randomcoloR) and [Rust](https://github.com/elementh/random_color).

### License

This project is licensed under the terms of the MIT license.
