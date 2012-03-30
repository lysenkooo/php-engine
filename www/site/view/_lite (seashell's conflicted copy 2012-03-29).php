<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $_title ?></title>
    <link rel="stylesheet" href="<?php echo $_path ?>static/style.css">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <header id="sheader">
          <h1>
          <a href="<?php echo $_path ?>">crashcube's blog</a>
          <?php if ($_user) { ?><a href="<?=$_path?>blog/add/">написать</a><?php } ?>
          </h1>
      </header>
      <section>
        <?php echo $content ?>
      </section>
    </div>
    <footer id="sfooter">
        <p>&copy; 2012</p>
    </footer>
  </body>
</html>