<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Register</h1>
        <? if ($messages->getFirstMessage('userMessage')): ?>
        <span> <?=$messages->getFirstMessage('userMessage')?></span>
        <br>
        <?endif?>
        <form action="/auth/register" method="post">
           <input type="text" name="login" id="login" placeholder="Login"> 
           <input type="password" name="password" id="password" placeholder="Password"> 
           <input type="password" name="password_rep" id="password_rep" placeholder="Confirm password"> 
            <button type="submit">Enter</button>
        </form>
    
    </body>
</html>
