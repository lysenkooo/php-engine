<article>
  <header>
    <h2>
      <?=$article['title']?>
      <?php if ($_user) { ?>
      <a href="<?=$_path?>blog/edit/<?=$article['id']?>">редактировать</a>
      <a href="<?=$_path?>blog/delete/<?=$article['id']?>">удалить</a>
      <?php } ?>
    </h2>
  </header>
  <p>
    <?=$article['text']?>
  </p>
  <footer class="muted">
    <p>Добавлено <?=$article['time']?></p>
  </footer>
</article>