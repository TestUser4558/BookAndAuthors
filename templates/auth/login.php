<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Login</h1>
        <? if ($messages->getFirstMessage('userMessage')): ?>
        <span> <?=$messages->getFirstMessage('userMessage')?></span>
        <br>
        <?endif?>
        <form action="/auth/login" method="post">
           <input type="text" name="login" id="login" placeholder="Login"> 
           <input type="password" name="password" id="password" placeholder="Password"> 
            <button type="submit">Enter</button>
        </form>
    
    </body>
</html>
