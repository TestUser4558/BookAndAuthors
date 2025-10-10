<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <a href="/logout">LOGOUT</a>
    <a href="/admin/authors/create">Add author</a>
    <a href="/admin/books">Books</a>
    <table>
        <?foreach($authors as $author):?>
        <tr>
            <td><?=$author['name']?></td>
            <td><a href="/admin/authors/<?=$author['id']?>/edit">Edit</a></td>
            <td><a href="/admin/authors/<?=$author['id']?>/delete">Delete</a></td>
        </tr>
        <?endforeach?>
    </table>
</body>

</html>
