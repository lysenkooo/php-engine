<article>
    <header>
        <h2>
        <?=$article['title']?></a>
        <?php if ($_user) { ?><a href="<?=$_path?>blog/edit/<?=$article['id']?>">редактировать</a><?php } ?>
        </h2>
    </header>
    <p><?=$article['text']?></p>
    <footer>
        <p>Добавлено <?=$article['time']?></p>
    </footer>
</article>