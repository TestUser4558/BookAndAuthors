<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <h1>Добавление</h1>
    <form action="" method="post">
        <input type="text" id="name" name="name" placeholder="name">
        <select name="authors[]" id="authors" multiple>
            <?foreach ($authors as $author) :?>
            <option value="<?=$author['id']?>"><?=$author['name']?></option>
            <?endforeach?>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>

</html>
