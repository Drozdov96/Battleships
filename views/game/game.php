<?php

/* @var $playerName string
 * @var $fieldOne array
 * @var $fieldTwo array
 */

use app\controllers\HtmlHelper;

echo HtmlHelper::getGamePage($playerName,
    $fieldOne, $fieldTwo);