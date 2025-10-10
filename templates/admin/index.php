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
    <a href="/admin/create">Add book</a>
    <a href="/admin/authors">Authors</a>
    <table>
        <?foreach($books as $book):?>
        <tr>
            <td><?=$book['name']?></td>
            <?if ($book['available'] == 0):?>
                <td>Unavailable</td>
            <?else:?>
                <td>Available</td>
            <?endif?>
            <td><?=$book['authors']?></td>
            <td><a href="/admin/<?=$book['id']?>/edit">Edit</a></td>
            <td><a href="/admin/<?=$book['id']?>/delete">Delete</a></td>
            <td><a href="/admin/books/<?=$book['id']?>">Book</a></td>
        </tr>
        <?endforeach?>
    </table>
</body>

</html>
