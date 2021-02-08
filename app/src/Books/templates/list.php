<?php
/**
 * @var array $books
 */
?>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book->title ?></td>
            <td><?= $book->author->first_name ?> <?= $book->author->last_name ?></td>
            <td>
                <a href="<?='/books/update/' . $book->id ?>">
                    Update
                </a><br>
                <a href="<?='/books/delete/' . $book->id ?>">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="/books/create">Create New Book</a>
