<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Аренда</h1>
        <form action="" method="post">
        <input type="text" id="user" name="user" placeholder="User"> 
        <input type="date" id="dateBegin" name="dateBegin" placeholder="Date begin"> 
        <input type="date" id="dateEnd" name="dateEnd" placeholder="Date end"> 
            <?if ($book['available'] == 0):?>
                <span>Book is now unavailable you have to return it</span>
                <td><a href="/admin/<?=$book['id']?>/return">Return</a></td>
            <?else: ?>
                <button type="submit">Submit</button>
            <?endif?>
        </form>
        <h1>История</h1>
        <table>
        <tr>
        <td>User</td>
        <td>Date begin</td>
        <td>Date end</td>
        </tr>
        <?foreach($history as $hist):?>
        <tr>
        <td><?=$hist['user']?></td>
        <td><?=$hist['date_begin']?></td>
        <td><?=$hist['date_end']?></td>
        </tr>
        <?endforeach?>
        </table>
    </body>
</html>
