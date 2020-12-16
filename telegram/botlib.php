<?php
/*
 * Telegram Bot Manual Library
 * Usage in hook.php file:
 * `require_once('botlib.php');`
 * 
 * Original repository for other stuff and maybe pull requests:
 * github.com/mahdymirzade/lib
 *
 */

class botlib {

	# Set botlib parameter to bot's api_key token
	public $token;
	public function __construct($token){
		$this->api_key = $token;
	}

	# Call methods with parameters, from api manual in a function named bot();
	public function bot($method,$datas=[]){
		$url = "https://api.telegram.org/bot".$this->api_key."/".$method;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
		$res = curl_exec($ch);
		if(curl_error($ch)){
			var_dump(curl_error($ch));
		}else{
			return json_decode($res);
		}
	}

	# Use this method to receive incoming updates using long polling([wiki](https://en.wikipedia.org/wiki/Push_technology#Long_polling)). An Arrayof Update objects is returned.
	public function getUpdates ($offset=null, $limit=null, $timeout=null, $allowed_updates=null) {
		return $this->bot('getUpdates', [
			'offset' => $offset,
			'limit' => $limit,
			'timeout' => $timeout,
			'allowed_updates' => $allowed_updates,
		]);
	}

	# Use this method to specify a url and receive incoming updates via an outgoingwebhook. Whenever there is an update for the bot, we will send an HTTPS POSTrequest to the specified url, containing a JSON-serialized Update. In case ofan unsuccessful request, we will give up after a reasonable amount ofattempts. Returns _True_ on success.
	public function setWebhook () {
		return $this->bot('setWebhook');
	}

	# Use this method to remove webhook integration if you decide to switch back togetUpdates. Returns _True_ on success.
	public function deleteWebhook ($drop_pending_updates=null) {
		return $this->bot('deleteWebhook', [
			'drop_pending_updates' => $drop_pending_updates,
		]);
	}

	# Use this method to get current webhook status. Requires no parameters. Onsuccess, returns a WebhookInfo object. If the bot is using getUpdates, willreturn an object with the _url_ field empty.
	public function getWebhookInfo () {
		return $this->bot('getWebhookInfo');
	}

	# A simple method for testing your bot's auth token. Requires no parameters.Returns basic information about the bot in form of a User object.
	public function getMe () {
		return $this->bot('getMe');
	}

	# Use this method to log out from the cloud Bot API server before launching thebot locally. You **must** log out the bot before running it locally, otherwisethere is no guarantee that the bot will receive updates. After a successfulcall, you can immediately log in on a local server, but will not be able tolog in back to the cloud Bot API server for 10 minutes. Returns _True_ onsuccess. Requires no parameters.
	public function logOut () {
		return $this->bot('logOut');
	}

	# Use this method to close the bot instance before moving it from one localserver to another. You need to delete the webhook before calling this methodto ensure that the bot isn't launched again after server restart. The methodwill return error 429 in the first 10 minutes after the bot is launched.Returns _True_ on success. Requires no parameters.
	public function close () {
		return $this->bot('close');
	}

	# Use this method to send text messages. On success, the sent Message isreturned.
	public function sendMessage ($chat_id, $text, $parse_mode=null, $entities=null, $disable_web_page_preview=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendMessage', [
			'chat_id' => $chat_id,
			'text' => $text,
			'parse_mode' => $parse_mode,
			'entities' => $entities,
			'disable_web_page_preview' => $disable_web_page_preview,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to forward messages of any kind. On success, the sent Messageis returned.
	public function forwardMessage ($chat_id, $from_chat_id, $disable_notification=null, $message_id) {
		return $this->bot('forwardMessage', [
			'chat_id' => $chat_id,
			'from_chat_id' => $from_chat_id,
			'disable_notification' => $disable_notification,
			'message_id' => $message_id,
		]);
	}

	# Use this method to copy messages of any kind. The method is analogous to themethod forwardMessages, but the copied message doesn't have a link to theoriginal message. Returns the MessageId of the sent message on success.
	public function copyMessage ($chat_id, $from_chat_id, $message_id, $caption=null, $parse_mode=null, $caption_entities=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('copyMessage', [
			'chat_id' => $chat_id,
			'from_chat_id' => $from_chat_id,
			'message_id' => $message_id,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send photos. On success, the sent Message is returned.
	public function sendPhoto ($chat_id, $photo, $caption=null, $parse_mode=null, $caption_entities=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendPhoto', [
			'chat_id' => $chat_id,
			'photo' => $photo,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send audio files, if you want Telegram clients to displaythem in the music player. Your audio must be in the .MP3 or .M4A format. Onsuccess, the sent Message is returned. Bots can currently send audio files ofup to 50 MB in size, this limit may be changed in the future.
	public function sendAudio () {
		return $this->bot('sendAudio');
	}

	# Use this method to send general files. On success, the sent Message isreturned. Bots can currently send files of any type of up to 50 MB in size,this limit may be changed in the future.
	public function sendDocument ($chat_id, $document, $thumb=null, $caption=null, $parse_mode=null, $caption_entities=null, $disable_content_type_detection=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendDocument', [
			'chat_id' => $chat_id,
			'document' => $document,
			'thumb' => $thumb,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'disable_content_type_detection' => $disable_content_type_detection,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send video files, Telegram clients support mp4 videos(other formats may be sent as Document). On success, the sent Message isreturned. Bots can currently send video files of up to 50 MB in size, thislimit may be changed in the future.
	public function sendVideo ($chat_id, $video, $duration=null, $width=null, $height=null, $thumb=null, $caption=null, $parse_mode=null, $caption_entities=null, $supports_streaming=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendVideo', [
			'chat_id' => $chat_id,
			'video' => $video,
			'duration' => $duration,
			'width' => $width,
			'height' => $height,
			'thumb' => $thumb,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'supports_streaming' => $supports_streaming,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send animation files (GIF or H.264/MPEG-4 AVC video withoutsound). On success, the sent Message is returned. Bots can currently sendanimation files of up to 50 MB in size, this limit may be changed in thefuture.
	public function sendAnimation ($chat_id, $animation, $duration=null, $width=null, $height=null, $thumb=null, $caption=null, $parse_mode=null, $caption_entities=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendAnimation', [
			'chat_id' => $chat_id,
			'animation' => $animation,
			'duration' => $duration,
			'width' => $width,
			'height' => $height,
			'thumb' => $thumb,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send audio files, if you want Telegram clients to displaythe file as a playable voice message. For this to work, your audio must be inan .OGG file encoded with OPUS (other formats may be sent as Audio orDocument). On success, the sent Message is returned. Bots can currently sendvoice messages of up to 50 MB in size, this limit may be changed in thefuture.
	public function sendVoice ($chat_id, $voice, $caption=null, $parse_mode=null, $caption_entities=null, $duration=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendVoice', [
			'chat_id' => $chat_id,
			'voice' => $voice,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'duration' => $duration,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# As of [v.4.0](https://telegram.org/blog/video-messages-and-telescope),Telegram clients support rounded square mp4 videos of up to 1 minute long. Usethis method to send video messages. On success, the sent Message is returned.
	public function sendVideoNote ($chat_id, $video_note, $duration=null, $length=null, $thumb=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendVideoNote', [
			'chat_id' => $chat_id,
			'video_note' => $video_note,
			'duration' => $duration,
			'length' => $length,
			'thumb' => $thumb,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send a group of photos, videos, documents or audios as analbum. Documents and audio files can be only grouped in an album with messagesof the same type. On success, an array of Messages that were sent is returned.
	public function sendMediaGroup ($chat_id, $media, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null) {
		return $this->bot('sendMediaGroup', [
			'chat_id' => $chat_id,
			'media' => $media,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
		]);
	}

	# Use this method to send point on the map. On success, the sent Message isreturned.
	public function sendLocation ($chat_id, $latitude, $longitude, $horizontal_accuracy=null, $live_period=null, $heading=null, $proximity_alert_radius=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendLocation', [
			'chat_id' => $chat_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'horizontal_accuracy' => $horizontal_accuracy,
			'live_period' => $live_period,
			'heading' => $heading,
			'proximity_alert_radius' => $proximity_alert_radius,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to edit live location messages. A location can be edited untilits _live_period_ expires or editing is explicitly disabled by a call tostopMessageLiveLocation. On success, if the edited message is not an inlinemessage, the edited Message is returned, otherwise _True_ is returned.
	public function editMessageLiveLocation ($chat_id=null, $message_id=null, $inline_message_id=null, $latitude, $longitude, $horizontal_accuracy=null, $heading=null, $proximity_alert_radius=null, $reply_markup=null) {
		return $this->bot('editMessageLiveLocation', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'horizontal_accuracy' => $horizontal_accuracy,
			'heading' => $heading,
			'proximity_alert_radius' => $proximity_alert_radius,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to stop updating a live location message before _live_period_expires. On success, if the message was sent by the bot, the sent Message isreturned, otherwise _True_ is returned.
	public function stopMessageLiveLocation ($chat_id=null, $message_id=null, $inline_message_id=null, $reply_markup=null) {
		return $this->bot('stopMessageLiveLocation', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send information about a venue. On success, the sentMessage is returned.
	public function sendVenue ($chat_id, $latitude, $longitude, $title, $address, $foursquare_id=null, $foursquare_type=null, $google_place_id=null, $google_place_type=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendVenue', [
			'chat_id' => $chat_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'title' => $title,
			'address' => $address,
			'foursquare_id' => $foursquare_id,
			'foursquare_type' => $foursquare_type,
			'google_place_id' => $google_place_id,
			'google_place_type' => $google_place_type,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send phone contacts. On success, the sent Message isreturned.
	public function sendContact ($chat_id, $phone_number, $first_name, $last_name=null, $vcard=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendContact', [
			'chat_id' => $chat_id,
			'phone_number' => $phone_number,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'vcard' => $vcard,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send a native poll. On success, the sent Message isreturned.
	public function sendPoll ($chat_id, $question, $options, $is_anonymous=null, $type=null, $allows_multiple_answers=null, $correct_option_id=null, $explanation=null, $explanation_parse_mode=null, $explanation_entities=null, $open_period=null, $close_date=null, $is_closed=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendPoll', [
			'chat_id' => $chat_id,
			'question' => $question,
			'options' => $options,
			'is_anonymous' => $is_anonymous,
			'type' => $type,
			'allows_multiple_answers' => $allows_multiple_answers,
			'correct_option_id' => $correct_option_id,
			'explanation' => $explanation,
			'explanation_parse_mode' => $explanation_parse_mode,
			'explanation_entities' => $explanation_entities,
			'open_period' => $open_period,
			'close_date' => $close_date,
			'is_closed' => $is_closed,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to send an animated emoji that will display a random value. Onsuccess, the sent Message is returned.
	public function sendDice ($chat_id, $emoji=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendDice', [
			'chat_id' => $chat_id,
			'emoji' => $emoji,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method when you need to tell the user that something is happening onthe bot's side. The status is set for 5 seconds or less (when a messagearrives from your bot, Telegram clients clear its typing status). Returns_True_ on success.
	public function sendChatAction () {
		return $this->bot('sendChatAction');
	}

	# Use this method to get a list of profile pictures for a user. Returns aUserProfilePhotos object.
	public function getUserProfilePhotos ($user_id=null, $offset=null, $limit=null) {
		return $this->bot('getUserProfilePhotos', [
			'user_id' => $user_id,
			'offset' => $offset,
			'limit' => $limit,
		]);
	}

	# Use this method to get basic info about a file and prepare it for downloading.For the moment, bots can download files of up to 20MB in size. On success, aFile object is returned. The file can then be downloaded via the link`https://api.telegram.org/file/bot<token>/<file_path>`, where `<file_path>` istaken from the response. It is guaranteed that the link will be valid for atleast 1 hour. When the link expires, a new one can be requested by callinggetFile again.
	public function getFile ($file_id=null) {
		return $this->bot('getFile', [
			'file_id' => $file_id,
		]);
	}

	# Use this method to kick a user from a group, a supergroup or a channel. In thecase of supergroups and channels, the user will not be able to return to thegroup on their own using invite links, etc., unless unbanned first. The botmust be an administrator in the chat for this to work and must have theappropriate admin rights. Returns _True_ on success.
	public function kickChatMember ($chat_id, $user_id, $until_date=null) {
		return $this->bot('kickChatMember', [
			'chat_id' => $chat_id,
			'user_id' => $user_id,
			'until_date' => $until_date,
		]);
	}

	# Use this method to unban a previously kicked user in a supergroup or channel.The user will **not** return to the group or channel automatically, but willbe able to join via link, etc. The bot must be an administrator for this towork. By default, this method guarantees that after the call the user is not amember of the chat, but will be able to join it. So if the user is a member ofthe chat they will also be **removed** from the chat. If you don't want this,use the parameter _only_if_banned_. Returns _True_ on success.
	public function unbanChatMember ($chat_id, $user_id, $only_if_banned=null) {
		return $this->bot('unbanChatMember', [
			'chat_id' => $chat_id,
			'user_id' => $user_id,
			'only_if_banned' => $only_if_banned,
		]);
	}

	# Use this method to restrict a user in a supergroup. The bot must be anadministrator in the supergroup for this to work and must have the appropriateadmin rights. Pass _True_ for all permissions to lift restrictions from auser. Returns _True_ on success.
	public function restrictChatMember ($chat_id, $user_id, $permissions, $until_date=null) {
		return $this->bot('restrictChatMember', [
			'chat_id' => $chat_id,
			'user_id' => $user_id,
			'permissions' => $permissions,
			'until_date' => $until_date,
		]);
	}

	# Use this method to promote or demote a user in a supergroup or a channel. Thebot must be an administrator in the chat for this to work and must have theappropriate admin rights. Pass _False_ for all boolean parameters to demote auser. Returns _True_ on success.
	public function promoteChatMember ($chat_id, $user_id, $is_anonymous=null, $can_change_info=null, $can_post_messages=null, $can_edit_messages=null, $can_delete_messages=null, $can_invite_users=null, $can_restrict_members=null, $can_pin_messages=null, $can_promote_members=null) {
		return $this->bot('promoteChatMember', [
			'chat_id' => $chat_id,
			'user_id' => $user_id,
			'is_anonymous' => $is_anonymous,
			'can_change_info' => $can_change_info,
			'can_post_messages' => $can_post_messages,
			'can_edit_messages' => $can_edit_messages,
			'can_delete_messages' => $can_delete_messages,
			'can_invite_users' => $can_invite_users,
			'can_restrict_members' => $can_restrict_members,
			'can_pin_messages' => $can_pin_messages,
			'can_promote_members' => $can_promote_members,
		]);
	}

	# Use this method to set a custom title for an administrator in a supergrouppromoted by the bot. Returns _True_ on success.
	public function setChatAdministratorCustomTitle ($chat_id, $user_id, $custom_title) {
		return $this->bot('setChatAdministratorCustomTitle', [
			'chat_id' => $chat_id,
			'user_id' => $user_id,
			'custom_title' => $custom_title,
		]);
	}

	# Use this method to set default chat permissions for all members. The bot mustbe an administrator in the group or a supergroup for this to work and musthave the _can_restrict_members_ admin rights. Returns _True_ on success.
	public function setChatPermissions ($chat_id, $permissions) {
		return $this->bot('setChatPermissions', [
			'chat_id' => $chat_id,
			'permissions' => $permissions,
		]);
	}

	# Use this method to generate a new invite link for a chat; any previouslygenerated link is revoked. The bot must be an administrator in the chat forthis to work and must have the appropriate admin rights. Returns the newinvite link as _String_ on success.
	public function exportChatInviteLink ($chat_id) {
		return $this->bot('exportChatInviteLink', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to set a new profile photo for the chat. Photos can't bechanged for private chats. The bot must be an administrator in the chat forthis to work and must have the appropriate admin rights. Returns _True_ onsuccess.
	public function setChatPhoto ($chat_id, $photo) {
		return $this->bot('setChatPhoto', [
			'chat_id' => $chat_id,
			'photo' => $photo,
		]);
	}

	# Use this method to delete a chat photo. Photos can't be changed for privatechats. The bot must be an administrator in the chat for this to work and musthave the appropriate admin rights. Returns _True_ on success.
	public function deleteChatPhoto ($chat_id) {
		return $this->bot('deleteChatPhoto', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to change the title of a chat. Titles can't be changed forprivate chats. The bot must be an administrator in the chat for this to workand must have the appropriate admin rights. Returns _True_ on success.
	public function setChatTitle ($chat_id, $title) {
		return $this->bot('setChatTitle', [
			'chat_id' => $chat_id,
			'title' => $title,
		]);
	}

	# Use this method to change the description of a group, a supergroup or achannel. The bot must be an administrator in the chat for this to work andmust have the appropriate admin rights. Returns _True_ on success.
	public function setChatDescription ($chat_id, $description=null) {
		return $this->bot('setChatDescription', [
			'chat_id' => $chat_id,
			'description' => $description,
		]);
	}

	# Use this method to add a message to the list of pinned messages in a chat. Ifthe chat is not a private chat, the bot must be an administrator in the chatfor this to work and must have the 'can_pin_messages' admin right in asupergroup or 'can_edit_messages' admin right in a channel. Returns _True_ onsuccess.
	public function pinChatMessage ($chat_id, $message_id, $disable_notification=null) {
		return $this->bot('pinChatMessage', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'disable_notification' => $disable_notification,
		]);
	}

	# Use this method to remove a message from the list of pinned messages in achat. If the chat is not a private chat, the bot must be an administrator inthe chat for this to work and must have the 'can_pin_messages' admin right ina supergroup or 'can_edit_messages' admin right in a channel. Returns _True_on success.
	public function unpinChatMessage ($chat_id, $message_id=null) {
		return $this->bot('unpinChatMessage', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
		]);
	}

	# Use this method to clear the list of pinned messages in a chat. If the chat isnot a private chat, the bot must be an administrator in the chat for this towork and must have the 'can_pin_messages' admin right in a supergroup or'can_edit_messages' admin right in a channel. Returns _True_ on success.
	public function unpinAllChatMessages ($chat_id) {
		return $this->bot('unpinAllChatMessages', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method for your bot to leave a group, supergroup or channel. Returns_True_ on success.
	public function leaveChat ($chat_id) {
		return $this->bot('leaveChat', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to get up to date information about the chat (current name ofthe user for one-on-one conversations, current username of a user, group orchannel, etc.). Returns a Chat object on success.
	public function getChat ($chat_id) {
		return $this->bot('getChat', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to get a list of administrators in a chat. On success, returnsan Array of ChatMember objects that contains information about all chatadministrators except other bots. If the chat is a group or a supergroup andno administrators were appointed, only the creator will be returned.
	public function getChatAdministrators ($chat_id) {
		return $this->bot('getChatAdministrators', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to get the number of members in a chat. Returns _Int_ onsuccess.
	public function getChatMembersCount ($chat_id) {
		return $this->bot('getChatMembersCount', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to get information about a member of a chat. Returns aChatMember object on success.
	public function getChatMember ($chat_id, $user_id) {
		return $this->bot('getChatMember', [
			'chat_id' => $chat_id,
			'user_id' => $user_id,
		]);
	}

	# Use this method to set a new group sticker set for a supergroup. The bot mustbe an administrator in the chat for this to work and must have the appropriateadmin rights. Use the field _can_set_sticker_set_ optionally returned ingetChat requests to check if the bot can use this method. Returns _True_ onsuccess.
	public function setChatStickerSet ($chat_id, $sticker_set_name) {
		return $this->bot('setChatStickerSet', [
			'chat_id' => $chat_id,
			'sticker_set_name' => $sticker_set_name,
		]);
	}

	# Use this method to delete a group sticker set from a supergroup. The bot mustbe an administrator in the chat for this to work and must have the appropriateadmin rights. Use the field _can_set_sticker_set_ optionally returned ingetChat requests to check if the bot can use this method. Returns _True_ onsuccess.
	public function deleteChatStickerSet ($chat_id) {
		return $this->bot('deleteChatStickerSet', [
			'chat_id' => $chat_id,
		]);
	}

	# Use this method to send answers to callback queries sent from [inlinekeyboards](/bots#inline-keyboards-and-on-the-fly-updating). The answer will bedisplayed to the user as a notification at the top of the chat screen or as analert. On success, _True_ is returned.
	public function answerCallbackQuery ($callback_query_id, $text=null, $show_alert=null, $url=null, $cache_time=null) {
		return $this->bot('answerCallbackQuery', [
			'callback_query_id' => $callback_query_id,
			'text' => $text,
			'show_alert' => $show_alert,
			'url' => $url,
			'cache_time' => $cache_time,
		]);
	}

	# Use this method to change the list of the bot's commands. Returns _True_ onsuccess.
	public function setMyCommands ($commands) {
		return $this->bot('setMyCommands', [
			'commands' => $commands,
		]);
	}

	# Use this method to get the current list of the bot's commands. Requires noparameters. Returns Array of BotCommand on success.
	public function getMyCommands () {
		return $this->bot('getMyCommands');
	}

	# Use this method to edit text and game messages. On success, if the editedmessage is not an inline message, the edited Message is returned, otherwise_True_ is returned.
	public function editMessageText ($chat_id=null, $message_id=null, $inline_message_id=null, $text, $parse_mode=null, $entities=null, $disable_web_page_preview=null, $reply_markup=null) {
		return $this->bot('editMessageText', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
			'text' => $text,
			'parse_mode' => $parse_mode,
			'entities' => $entities,
			'disable_web_page_preview' => $disable_web_page_preview,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to edit captions of messages. On success, if the editedmessage is not an inline message, the edited Message is returned, otherwise_True_ is returned.
	public function editMessageCaption ($chat_id=null, $message_id=null, $inline_message_id=null, $caption=null, $parse_mode=null, $caption_entities=null, $reply_markup=null) {
		return $this->bot('editMessageCaption', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
			'caption' => $caption,
			'parse_mode' => $parse_mode,
			'caption_entities' => $caption_entities,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to edit animation, audio, document, photo, or video messages.If a message is part of a message album, then it can be edited only to anaudio for audio albums, only to a document for document albums and to a photoor a video otherwise. When an inline message is edited, a new file can't beuploaded. Use a previously uploaded file via its file_id or specify a URL. Onsuccess, if the edited message was sent by the bot, the edited Message isreturned, otherwise _True_ is returned.
	public function editMessageMedia ($chat_id=null, $message_id=null, $inline_message_id=null, $media, $reply_markup=null) {
		return $this->bot('editMessageMedia', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
			'media' => $media,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to edit only the reply markup of messages. On success, if theedited message is not an inline message, the edited Message is returned,otherwise _True_ is returned.
	public function editMessageReplyMarkup ($chat_id=null, $message_id=null, $inline_message_id=null, $reply_markup=null) {
		return $this->bot('editMessageReplyMarkup', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to stop a poll which was sent by the bot. On success, thestopped Poll with the final results is returned.
	public function stopPoll ($chat_id, $message_id, $reply_markup=null) {
		return $this->bot('stopPoll', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to delete a message, including service messages, with thefollowing limitations:  \- A message can only be deleted if it was sent less than 48 hours ago.  \- A dice message in a private chat can only be deleted if it was sent morethan 24 hours ago.  \- Bots can delete outgoing messages in private chats, groups, andsupergroups.  \- Bots can delete incoming messages in private chats.  \- Bots granted _can_post_messages_ permissions can delete outgoing messagesin channels.  \- If the bot is an administrator of a group, it can delete any message there.  \- If the bot has _can_delete_messages_ permission in a supergroup or achannel, it can delete any message there.  Returns _True_ on success.
	public function deleteMessage ($chat_id, $message_id) {
		return $this->bot('deleteMessage', [
			'chat_id' => $chat_id,
			'message_id' => $message_id,
		]);
	}

	# Use this method to send static .WEBP or[animated](https://telegram.org/blog/animated-stickers) .TGS stickers. Onsuccess, the sent Message is returned.
	public function sendSticker ($chat_id, $sticker, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendSticker', [
			'chat_id' => $chat_id,
			'sticker' => $sticker,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to get a sticker set. On success, a StickerSet object isreturned.
	public function getStickerSet ($name=null) {
		return $this->bot('getStickerSet', [
			'name' => $name,
		]);
	}

	# Use this method to upload a .PNG file with a sticker for later use in_createNewStickerSet_ and _addStickerToSet_ methods (can be used multipletimes). Returns the uploaded File on success.
	public function uploadStickerFile ($user_id, $png_sticker) {
		return $this->bot('uploadStickerFile', [
			'user_id' => $user_id,
			'png_sticker' => $png_sticker,
		]);
	}

	# Use this method to create a new sticker set owned by a user. The bot will beable to edit the sticker set thus created. You **must** use exactly one of thefields _png_sticker_ or _tgs_sticker_. Returns _True_ on success.
	public function createNewStickerSet ($user_id, $name, $title, $png_sticker=null, $tgs_sticker=null, $emojis, $contains_masks=null, $mask_position=null) {
		return $this->bot('createNewStickerSet', [
			'user_id' => $user_id,
			'name' => $name,
			'title' => $title,
			'png_sticker' => $png_sticker,
			'tgs_sticker' => $tgs_sticker,
			'emojis' => $emojis,
			'contains_masks' => $contains_masks,
			'mask_position' => $mask_position,
		]);
	}

	# Use this method to add a new sticker to a set created by the bot. You **must**use exactly one of the fields _png_sticker_ or _tgs_sticker_. Animatedstickers can be added to animated sticker sets and only to them. Animatedsticker sets can have up to 50 stickers. Static sticker sets can have up to120 stickers. Returns _True_ on success.
	public function addStickerToSet ($user_id, $name, $png_sticker=null, $tgs_sticker=null, $emojis, $mask_position=null) {
		return $this->bot('addStickerToSet', [
			'user_id' => $user_id,
			'name' => $name,
			'png_sticker' => $png_sticker,
			'tgs_sticker' => $tgs_sticker,
			'emojis' => $emojis,
			'mask_position' => $mask_position,
		]);
	}

	# Use this method to move a sticker in a set created by the bot to a specificposition. Returns _True_ on success.
	public function setStickerPositionInSet ($sticker=null, $position=null) {
		return $this->bot('setStickerPositionInSet', [
			'sticker' => $sticker,
			'position' => $position,
		]);
	}

	# Use this method to delete a sticker from a set created by the bot. Returns_True_ on success.
	public function deleteStickerFromSet ($sticker=null) {
		return $this->bot('deleteStickerFromSet', [
			'sticker' => $sticker,
		]);
	}

	# Use this method to set the thumbnail of a sticker set. Animated thumbnails canbe set for animated sticker sets only. Returns _True_ on success.
	public function setStickerSetThumb ($name, $user_id, $thumb=null) {
		return $this->bot('setStickerSetThumb', [
			'name' => $name,
			'user_id' => $user_id,
			'thumb' => $thumb,
		]);
	}

	# Use this method to send answers to an inline query. On success, _True_ isreturned.  No more than **50** results per query are allowed.
	public function answerInlineQuery ($inline_query_id, $results, $cache_time=null, $is_personal=null, $next_offset=null, $switch_pm_text=null, $switch_pm_parameter=null) {
		return $this->bot('answerInlineQuery', [
			'inline_query_id' => $inline_query_id,
			'results' => $results,
			'cache_time' => $cache_time,
			'is_personal' => $is_personal,
			'next_offset' => $next_offset,
			'switch_pm_text' => $switch_pm_text,
			'switch_pm_parameter' => $switch_pm_parameter,
		]);
	}

	# Use this method to send invoices. On success, the sent Message is returned.
	public function sendInvoice ($chat_id, $title, $description, $payload, $provider_token, $start_parameter, $currency, $prices, $provider_data=null, $photo_url=null, $photo_size=null, $photo_width=null, $photo_height=null, $need_name=null, $need_phone_number=null, $need_email=null, $need_shipping_address=null, $send_phone_number_to_provider=null, $send_email_to_provider=null, $is_flexible=null, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendInvoice', [
			'chat_id' => $chat_id,
			'title' => $title,
			'description' => $description,
			'payload' => $payload,
			'provider_token' => $provider_token,
			'start_parameter' => $start_parameter,
			'currency' => $currency,
			'prices' => $prices,
			'provider_data' => $provider_data,
			'photo_url' => $photo_url,
			'photo_size' => $photo_size,
			'photo_width' => $photo_width,
			'photo_height' => $photo_height,
			'need_name' => $need_name,
			'need_phone_number' => $need_phone_number,
			'need_email' => $need_email,
			'need_shipping_address' => $need_shipping_address,
			'send_phone_number_to_provider' => $send_phone_number_to_provider,
			'send_email_to_provider' => $send_email_to_provider,
			'is_flexible' => $is_flexible,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# If you sent an invoice requesting a shipping address and the parameter_is_flexible_ was specified, the Bot API will send an Update with a_shipping_query_ field to the bot. Use this method to reply to shippingqueries. On success, True is returned.
	public function answerShippingQuery ($shipping_query_id, $ok, $shipping_options=null, $error_message=null) {
		return $this->bot('answerShippingQuery', [
			'shipping_query_id' => $shipping_query_id,
			'ok' => $ok,
			'shipping_options' => $shipping_options,
			'error_message' => $error_message,
		]);
	}

	# Once the user has confirmed their payment and shipping details, the Bot APIsends the final confirmation in the form of an Update with the field_pre_checkout_query_. Use this method to respond to such pre-checkout queries.On success, True is returned. **Note:** The Bot API must receive an answerwithin 10 seconds after the pre-checkout query was sent.
	public function answerPreCheckoutQuery ($pre_checkout_query_id, $ok, $error_message=null) {
		return $this->bot('answerPreCheckoutQuery', [
			'pre_checkout_query_id' => $pre_checkout_query_id,
			'ok' => $ok,
			'error_message' => $error_message,
		]);
	}

	# Use this method to send a game. On success, the sent Message is returned.
	public function sendGame ($chat_id, $game_short_name, $disable_notification=null, $reply_to_message_id=null, $allow_sending_without_reply=null, $reply_markup=null) {
		return $this->bot('sendGame', [
			'chat_id' => $chat_id,
			'game_short_name' => $game_short_name,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'allow_sending_without_reply' => $allow_sending_without_reply,
			'reply_markup' => $reply_markup,
		]);
	}

	# Use this method to set the score of the specified user in a game. On success,if the message was sent by the bot, returns the edited Message, otherwisereturns _True_. Returns an error, if the new score is not greater than theuser's current score in the chat and _force_ is _False_.
	public function setGameScore ($user_id, $score, $force=null, $disable_edit_message=null, $chat_id=null, $message_id=null, $inline_message_id=null) {
		return $this->bot('setGameScore', [
			'user_id' => $user_id,
			'score' => $score,
			'force' => $force,
			'disable_edit_message' => $disable_edit_message,
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
		]);
	}

	# Use this method to get data for high score tables. Will return the score ofthe specified user and several of their neighbors in a game. On success,returns an _Array_ of GameHighScore objects.
	public function getGameHighScores ($user_id, $chat_id=null, $message_id=null, $inline_message_id=null) {
		return $this->bot('getGameHighScores', [
			'user_id' => $user_id,
			'chat_id' => $chat_id,
			'message_id' => $message_id,
			'inline_message_id' => $inline_message_id,
		]);
	}

}
