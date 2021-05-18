# Botlib 0.1

A simple telegram bot library.

## Usage

1. add `require_once("botlib.php");` to your file

2. make your new bot with `$bot = new botlib("APIKEY");` - APIKEY : bot's token

3. use telegram's methods with a simple call of your bot:

`$bot->method(data);` - method : name of the method , data : parameters

## Example
**Send a message to 821349528:**
```
<?php

require_once("botlib.php");

$bot = new botlib("14335...:AAGXqkM...");

$bot->sendMessage(821349528,"This is a test from botlib 👋");
```

## Code Examples

* filetourl : Send files and recieve direct links [source code](examples/filetourl.php)
