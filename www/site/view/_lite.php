<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $_title ?></title>
    <!--[if lt IE 9]>
    <script src="<?=$_path?>static/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet/less" type="text/css" href="<?=$_path?>static/styles.less">
    <script src="<?=$_path?>static/less.js" type="text/javascript"></script>
    <script src="<?=$_path?>static/jquery.js" type="text/javascript"></script>
    <script src="<?=$_path?>static/main.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="col6">
      <header class="hat">
        <h1><a href="<?php echo $_path ?>">crashcube's blog</a>

        </h1>
      </header>
      <nav>
        <ul>
          <li><a href="<?=$_path?>blog/">Блог</a></li>
          <li><a href="<?=$_path?>about/">О сайте</a></li>
          <?php if ($_user) { ?>
          <li><a href="<?=$_path?>blog/add/">Написать</a></li>
          <li><a href="<?=$_path?>auth/"><?=$_user?></a></li>
          <?php } ?>
        </ul>
      </nav>
      <section>
        <?php echo $content ?>
      </section>
      <footer class="foot">
          <p>&copy; 2012 | Denis Lysenko</p>
      </footer>
    </div>
  </body>
</html>
