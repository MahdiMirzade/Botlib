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
    file_put_contents("botlib.php",file_get_contents("https://raw.githubusercontent.com/mahdymirzade/lib/main/telegram/botlib.php"));

# Importing botlib
require_once('botlib.php');

# Making your botlib & extract bot's username
$bot = new botlib("[*[*TOKEN*]*]");
$usernamebot = $bot->getme()->result->username;

# Telegram update handler
$update = json_decode(file_get_contents('php://input'));
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

# Connecting your mysql server
$sql = new mysqli("[*[*SERVER*]*]","[*[*USERNAME*]*]","[*[*PASSWORD*]*]","[*[*DATABASE*]*]");
$sql->query("CREATE TABLE IF NOT EXISTS usrs ( id INT NOT NULL, dt INT NOT NULL, step TEXT NULL, PRIMARY KEY ( id ) )");
$sql->query("CREATE TABLE IF NOT EXISTS urls ( id INT NOT NULL, ln TEXT NOT NULL, cr INT NOT NULL, dt INT NOT NULL, md INT NOT NULL, dl TEXT NOT NULL, PRIMARY KEY ( id ) )");

# Handling user's data from mysql DB
$usrd = $sql->query("SELECT * FROM `usrs` WHERE `id` = $from_id")->fetch_assoc();

# Making user's data if not found
if(!$usrd)
    $sql->query("INSERT INTO `usrs` (`id`,`dt`,`step`) VALUES ($from_id,$dt,'')");

# Getting unix-time in case to change it for Y/m/d format or... Idk for later
$dt = time();

# Handling urls and starts
if(preg_match("/\/[Ss][Tt][Aa][Rr][Tt](.*)/",$text,$matches)){
    if($matches[1]){
        $ln = str_replace(" ","",$matches[1]);
        $file = $sql->query("SELECT * FROM `urls` WHERE `ln` = '$ln'")->fetch_assoc();
        if($file)
            $bot->copymessage($from_id,$file['cr'],$file['md']);
        else
            $bot->sendmessage($from_id,"👋 Hi this is file to url bot, welcome.\n\nI'm lucky to say that you can send me everything,\nand get a direct url to share it.");
    }else
        $bot->sendmessage($from_id,"👋 Hi this is file to url bot, welcome.\n\nI'm lucky to say that you can send me everything,\nand get a direct url to share it.");
}

# Saving everything except for texts in the database
elseif(!$text){
    $id = $sql->query("SELECT * FROM `urls`")->num_rows;
    $ln = uniqid();
    $dl = $from_id.",";
    $sql->query("INSERT INTO `urls` (`id`,`ln`,`cr`,`dt`,`md`,`dl`) VALUES ($id,'$ln',$from_id,$dt,$message_id,'$dl')");
    $bot->sendmessage($from_id,"Yay, Now you can share this link:\nt.me/".$usernamebot."?start=".$ln);
}
