<?php foreach ($articles as $article) { ?>
<article>
  <header>
    <h2><a href="<?php echo $_path ?>blog/<?php echo $article['id'] ?>"><?php echo $article['title'] ?></a></h2>
  </header>
  <p><?php echo $article['text'] ?></p>
  <footer>
      <p>Добавлено <?php echo $article['time'] ?></p>
  </footer>
</article>
<?php } ?>