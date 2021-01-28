<?php
/**
 * @var array $authors
 * @var array $currencies
 */
?>
<form method="get" action="">
    <table>
        <tr>
            <td>Author</td>
            <td>
                <select name="author_id">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author->id ?>"><?= $author->first_name ?> <?= $author->last_name ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Title</td>
            <td><input type="text" name="title" /> </td>
        </tr>

        <?php foreach ($currencies as $currency): ?>
        <tr>
            <td>Price (<?= $currency->iso ?>)</td>
            <td><input type="text" name="price[<?= $currency->iso ?>]" /></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2" align="right">
                <input type="submit" value="Create" />
            </td>
        </tr>
    </table>
</form>
