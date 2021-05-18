<?php

/*
 * File to Url Bot
 *
 * This bot is an example of `botlib.php` library
 * This code is for users to upload files and get a url in case to share the link to others...
 *
 * github.com/mahdymirzade/lib
 *
 */

# Recieving botlib if it wasn't there before
if(!file_exists("botlib.php"))
    copy("https://raw.githubusercontent.com/MahdyMirzade/Botlib/main/botlib.php","botlib.php");

# Importing botlib
require_once('botlib.php');

# Making your botlib & extract bot's username
$bot = new botlib("[*[*TOKEN*]*]");
$usernamebot = $bot->getme()->result->username;

# Telegram update handler
$update = json_decode(file_get_contents('php://input'));
if(!$update)
    die("404 Not Found");
if($update->message){
    $message = $update->message;
    $message_id = $update->message->message_id;
    $chat_id = $message->chat->id;
    $from_id = $message->from->id;
    $text = $message->text;
}
if($update->callback_query){
    $message = $update->callback_query->message;
    $from_id = $message->from->id;
    $data = $update->callback_query->data;
}

$language = [
    "English" => [
        "start_txt" => "👋 Hello ",
        "404" => "<b>404 Not Found</b>",
    ],
    "Persian" => [
        "start_txt" => "👋 درود ",
        "404" => "<b>۴۰۴ یافت نشد</b>",
    ],
];

$defaultLang = "English";

function lang ($term, $lang=null) {
    global $defaultLang, $language;
    if ($lang)
        $defaultLang = $lang;
    return $language[$defaultLang][$term];
}

# Connecting your mysql server
$sql = new mysqli("[*[*SERVER*]*]","[*[*USERNAME*]*]","[*[*PASSWORD*]*]","[*[*DATABASE*]*]");
$sql->query("CREATE TABLE IF NOT EXISTS usrs ( id INT NOT NULL, dt INT NOT NULL, step TEXT NULL, PRIMARY KEY ( id ) )");

# Handling user's data from mysql DB
$usrd = $sql->query("SELECT * FROM `usrs` WHERE `id` = $from_id")->fetch_assoc();

# Making user's data if not found
if(!$usrd)
    $sql->query("INSERT INTO `usrs` (`id`,`dt`,`step`) VALUES ($from_id,$dt,'')");

# Getting unix-time in case to change it for Y/m/d format or... Idk for later
$dt = time();

# Handling urls and starts
if(preg_match("/\/[Ss][Tt][Aa][Rr][Tt](.*)/",$text,$matches))
    $bot->sendmessage($from_id,lang("start_txt"),"html",null,true);
