<?php
/**
 * main.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;

rmrevin\yii\module\Comments\tests\web\assets\AppAssetBundle::register($this);

$this->beginPage();

?><!DOCTYPE html>
<html>
<head>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    echo Html::csrfMetaTags();
    echo Html::tag('title', $this->title);

    echo Html::tag('meta', '', ['charset' => Yii::$app->charset]);

    $this->head();
    ?>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<?php

$this->beginBody();

?>
<div class="container">
    <?= $content ?>
</div>
<?php

$this->endBody();

?>

</body>
</html><?php

$this->endPage();