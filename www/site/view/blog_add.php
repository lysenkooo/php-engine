<form action="#" method="post" class="form">
    <h2>Добавить заметку</h2>
    <p>
        <input type="text" name="title" placeholder="Название заметки" value="<?php echo $title ?>"><br>
        <textarea name="text" placeholder="Заметка"><?php echo $text ?></textarea><br>
        <input type="submit" value="Опубликовать">
    </p>
</form>