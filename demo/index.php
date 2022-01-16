<?php
include '../src/RandomColor.php';
use \Colors\RandomColor;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

  <title>Random Color generator for PHP</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  
  <style>
  .container { max-width:600px; }
  p { margin-top:1em font-size:1.2em; color:#555; }
  h2, h3, pre { margin-top:2em; }
  .output span { display:inline-block; width:47px; height:47px; margin:8px; border-radius:50%; }
  .footer { padding-top:40px; padding-bottom:40px; margin-top:40px; border-top:1px solid #EEE; }
  .btn-download { border-radius:22px; margin-top:2em; }
  .btn-reload { position:fixed; top:10px; left:10px; }
  </style>
</head>

<body class="container">

  <button onclick="document.location.reload()" class="btn btn-link btn-reload">
    <i class="glyphicon glyphicon-repeat"></i>
    Reload demo
  </button>
  
  <header class="page-header">
    <h1>RandomColor <small>A color generator for PHP</small></h1>
  </header>
  
  <h2>What is it?</h2>
  <p>
    This is a port of the <a href="http://llllll.li/randomColor">randomColor.js</a> script created by David Merfield.
  </p>
  <p>
    RandomColor generates <b>attractive colors</b> by default. More specifically, RandomColor produces bright colors with a reasonably high saturation. This makes randomColor particularly useful for <b>data visualizations</b> and <b>generative art</b>.
  </p>
  
  <a class="btn btn-danger btn-lg btn-download" href="https://github.com/mistic100/RandomColor.php">
    Get the code on GitHub &nbsp;&nbsp;
    <i class="glyphicon glyphicon-arrow-right"></i>
  </a>
  
  <h2>Examples</h2>
  
  <p>
    Once you have included <a href="https://github.com/mistic100/RandomColor.php">RandomColor.class.php</a> on your app, calling <code>RandomColor::one($options)</code> or <code>RandomColor::many($count, $options)</code> will return a random attractive color. Beneath is the live output of 36 generations.
  </p>
  <pre>RandomColor::many(36);</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(36) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <p>
    You can also pass an options object to randomColor. This allows you to specify the hue, luminosity and the format of colors to generate.
  </p>
  
  <h3>Format</h3>
  <?php $c = RandomColor::one(array('format'=>'hsv','luminosity'=>'dark')); ?>
  <pre>
RandomColor::one(array('format'=>'hex'));
  <?php echo '<span style="color:' . RandomColor::hsv2hex($c) . ';">// "' . RandomColor::hsv2hex($c) . '"</span>'; ?>


RandomColor::one(array('format'=>'hsv'));
  <?php echo '<span style="color:' . RandomColor::hsv2hex($c) . ';">// ' . preg_replace('/\s+|,\s+(\))/', '$1', var_export($c, true)) . '</span>'; ?>


RandomColor::one(array('format'=>'hsl'));
  <?php echo '<span style="color:' . RandomColor::hsv2hex($c) . ';">// ' . preg_replace('/\s+|,\s+(\))/', '$1', var_export(RandomColor::hsv2hsl($c), true)) . '</span>'; ?>


RandomColor::one(array('format'=>'rgb'));
  <?php echo '<span style="color:' . RandomColor::hsv2hex($c) . ';">// ' . preg_replace('/\s+|,\s+(\))/', '$1', var_export(RandomColor::hsv2rgb($c), true)) . '</span>'; ?>


RandomColor::one(array('format'=>'hslCss'));
  <?php echo '<span style="color:' . RandomColor::hsv2hex($c) . ';">// "' . RandomColor::format($c, 'hslCss') . '"</span>'; ?>


RandomColor::one(array('format'=>'rgbCss'));
  <?php echo '<span style="color:' . RandomColor::hsv2hex($c) . ';">// "' . RandomColor::format($c, 'rgbCss') . '"</span>'; ?>
</pre>
  
  <h3>Similar colors</h3>
  <pre>RandomColor::many(18, array('hue'=>'red'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'red')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'orange'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'orange')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'yellow'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'yellow')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'green'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'green')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'blue'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'blue')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'purple'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'purple')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'pink'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'pink')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <pre>RandomColor::many(18, array('hue'=>'monochrome'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(18, array('hue'=>'monochrome')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <h3>Multiple colors</h3>
  <pre>RandomColor::many(27, array('hue'=>array('blue', 'yellow')));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(27, array('hue'=>array('blue', 'yellow'))) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <h3>Light colors</h3>
  <pre>RandomColor::many(27, array('luminosity'=>'light'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(27, array('luminosity'=>'light')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <h3>Dark colors</h3>
  <pre>RandomColor::many(27, array('luminosity'=>'dark'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(27, array('luminosity'=>'dark')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <h3>Truly random colors</h3>
  <pre>RandomColor::many(36, array('luminosity'=>'random', 'hue'=>'random'));</pre>
  <div class="output">
  <?php
  foreach (RandomColor::many(36, array('luminosity'=>'random', 'hue'=>'random')) as $c) echo '<span style="background:' . $c . ';"></span>';
  ?>
  </div>
  
  <a class="btn btn-danger btn-lg btn-download" href="https://github.com/mistic100/RandomColor.php">
    Get this on GitHub &nbsp;&nbsp;
    <i class="glyphicon glyphicon-arrow-right"></i>
  </a>
  
  <footer class="footer">
    <p>Made by <a href="http://www.strangeplanet.fr">Damien "Mistic" Sorel</a> based on the work of <a href="http://twitter.com/davidmerfieId">David Merfield</a>. Licensed under the MIT License.</p>
  </footer>
  
</body>
</html>
