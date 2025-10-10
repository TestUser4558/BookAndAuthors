<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    <a href="/login">Log-in</a>
    <br>
    <a href="/register">Sing-in</a>
    <table>
    <?foreach($books as $book):?> 
    <tr>
        <td><?=$book['name']?></td>
        <td><?=$book['authors']?></td>
    </tr>
    <?endforeach?>
    </table>
    </body>
</html>
