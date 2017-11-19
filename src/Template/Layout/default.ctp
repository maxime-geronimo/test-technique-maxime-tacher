<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'PROFIL PIC MANAGER';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSS -->
    <?= $this->Html->css('pic_manager.css') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('materialize/css/materialize.css') ?>

    <!-- JS -->
    <?= $this->Html->script('jquery-3.2.1.min.js') ?>
    <?= $this->Html->script('../css/materialize/js/materialize.min.js'); ?>
    <?= $this->Html->script('init.js') ?>
    <?= $this->Html->script('medias.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar" data-topbar role="navigation">
       <div class="page-title">
           <?= $cakeDescription; ?>
       </div>
        <?php
          $pic_default_url = (!empty($pic_default) ? $pic_default->url : "geronimo-logo.png");
            echo  $this->Html->image($pic_default_url, ['class'=>'profil_pic']);
        ?>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <!-- MODAL -->
    <?= $this->element('Modal/modal-pic-editor'); ?>
    <footer>
    </footer>
<script>
    //init.js
    init_baseurl("<?= $this->Url->build('/',true); ?>");
</script>
</body>
</html>
