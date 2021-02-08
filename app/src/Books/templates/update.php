<?php
/**
 * @var array $authors
 * @var object $book
 */
?>

<form method="post" action="<?='/books/update/' . $book->id ?>">
    <?=var_dump($book);?>
    <input type="hidden" name="id" value="<?= $book->id ?>" />
    <table>
        <tr>
            <td>Author</td>
            <td>
                <select name="author_id">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author->id ?>" <?=$author->id === $book->author_id ?' selected="selected"' : '' ?>"><?= $author->first_name ?> <?= $author->last_name ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Title</td>
            <td><input type="text" name="title" value="<?= $book->title ?>" /> </td>
        </tr>

        <tr>
            <td>Price (ZAR)</td>
            <td><input type="text" name="price" value="<?= $book->price ?>" /></td>
        </tr>

        <tr>
            <td colspan="2" align="right">
                <input type="submit" value="Update" />
            </td>
        </tr>
    </table>
</form>
