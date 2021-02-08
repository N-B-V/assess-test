<?php
/**
 * @var array $authors
 * @var array $currencies
 */
?>
<form method="post" action="">
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

        <tr>
            <td>Currency</td>
            <td>
                <select name="currency_id">
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?= $currency->id ?>"><?= $currency->iso ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Price</td>
            <td><input type="text" name="price" /></td>
        </tr>

        <tr>
            <td colspan="2" align="right">
                <input type="submit" value="Create" />
            </td>
        </tr>
    </table>
</form>
