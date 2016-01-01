<?php

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors', '1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

// namespaces
$autoloader = __DIR__.'/../vendor/autoload.php';
if (file_exists($autoloader)) {
    require_once $autoloader;
} else {
    die('You need to run Composer on the package to install dependencies');
}

/**
 * For security, transform a realpath as '/[***]/package_root/...'
 *
 * @param string $path
 * @param int $depth_from_root
 *
 * @return string
 */
function _getSecuredRealPath($path, $depth_from_root = 1)
{
    $ds = DIRECTORY_SEPARATOR;
    $parts = explode($ds, realpath('.'));
    for ($i=0; $i<=$depth_from_root; $i++) {
        array_pop($parts);
    }
    return str_replace(join($ds, $parts), $ds.'[***]', $path);
}

$controller = __DIR__.'/DemoController.php';
if (file_exists($controller)) {
    require_once $controller;
} else {
    die('Controller not found!');
}
$demo = new DemoController;
$email = array();
$ok_email = $demo->treat($email);

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Test & documentation of PHP "MIME Email" package</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/normalize.css" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/main.css" />
    <script src="assets/html5boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
    <link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <header id="top" role="banner">
        <hgroup>
            <h1>Tests of PHP <em>MIME Email</em> package</h1>
            <h2 class="slogan">The PHP package of Les Ateliers Pierrot to send full emails.</h2>
        </hgroup>
        <div class="hat">
            <p>These pages show and demonstrate the use and functionality of the <a href="https://github.com/atelierspierrot/mime-email">atelierspierrot/mime-email</a> PHP package you just downloaded.</p>
        </div>
    </header>

    <nav>
        <div class="info">
            <p><a href="https://github.com/atelierspierrot/mime-email">See online on GitHub</a></p>
            <p class="comment">The sources of this plugin are hosted on <a href="http://github.com">GitHub</a>. To follow sources updates, report a bug or read opened bug tickets and any other information, please see the GitHub website above.</p>
        </div>

        <p class="credits" id="user_agent"></p>
    </nav>

    <div id="content" role="main">

        <article>

<?php if (!is_null($ok_email)) : ?>
    <h2>Form results</h2>
    <?php if ($ok_email===true) : ?>
    <p style="font-weight: bold; color: green">OK - Your email has been sent!</p>
    <?php else : ?>
    <p style="font-weight: bold; color: red">ERROR - Your email has NOT been sent! (see errors below)</p>
    <?php endif; ?>
<pre>
<?php var_export($email); ?>
</pre>    
<?php endif; ?>

    <h2>Mailer form</h2>
    <form method="post" action="">

<?php foreach ($demo->fields as $i=>$fieldset) : ?>
        <fieldset>
            <legend><?php echo $fieldset['label']; ?></legend>
        <?php if (isset($fieldset['comment'])) : ?>
            <p style="font-size: .9em; font-style: italic;"><?php echo $fieldset['comment']; ?></p>
        <?php endif; ?>
        <?php foreach ($fieldset['fields'] as $name=>$field) : ?>
            <p><label>
                <?php echo $field['label']; ?>&nbsp;:
                <br />
            <?php if (!isset($field['type']) || $field['type']==='text') : ?>
                <input type="text" name="mimemail[<?php echo $i; ?>][<?php echo $name; ?>]" value="<?php echo $demo->isPosted($i.'.'.$name); ?>" style="width: 60%" />
            <?php elseif ($field['type']==='textarea') : ?>
                <textarea name="mimemail[<?php echo $i; ?>][<?php echo $name; ?>]" style="width: 80%; height: 200px;"><?php echo htmlentities($demo->isPosted($i.'.'.$name)); ?></textarea>
            <?php endif; ?>
            </label></p>
        <?php endforeach; ?>
        </fieldset>
<?php endforeach; ?>

        <input type="submit" name="spool" value="Spool email" />
        <input type="submit" name="send" value="Send email" />
        <input type="reset" />

    </form>

<pre>
<?php var_export($demo); ?>
</pre>

        </article>
    </div>

    <footer id="footer">
        <div class="credits float-left">
            This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
        </div>
        <div class="credits float-right">
            <a href="http://github.com/atelierspierrot/mime-email">atelierspierrot/mime-email</a> package by <a href="https://github.com/atelierspierrot">Les Ateliers Pierrot</a> under <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache 2.0</a> license.
        </div>
    </footer>

    <div class="back_menu" id="short_navigation">
        <a href="#top" title="Back to the top of the page"><span class="text">Back to top&nbsp;</span>&uarr;</a>
        <ul id="short_menu" class="menu" role="navigation"></ul>
    </div>

    <div id="message_box" class="msg_box"></div>

<!-- jQuery lib -->
<script src="assets/js/jquery-1.9.1.min.js"></script>

<!-- HTML5 boilerplate -->
<script src="assets/html5boilerplate/js/plugins.js"></script>

<!-- jQuery.highlight plugin -->
<script src="assets/js/highlight.js"></script>

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>
$(function() {
    initBacklinks();
    activateMenuItem();
    getToHash();
    buildFootNotes();
    addCSSValidatorLink('assets/styles.css');
    addHTMLValidatorLink();
    $("#user_agent").html( navigator.userAgent );
    $('pre.code').highlight({source:0, indent:'tabs', code_lang: 'data-language'});
});
</script>
</body>
</html>
