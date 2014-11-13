# Chatty

A library to send messages to different group chat services (Slack, HipChat).

It can easily be used to send notifications about what's happening in your app (user signed up, etc)

## Authors

[Philip Manavopoulos](https://github.com/manavo).

## Installation

Install via Composer

```
composer require manavo/chatty
```

## Services

Supported services at the moment are:

* Slack
* HipChat

## Usage

### Slack

```php
$slackUrl = 'https://my.slack.com/services/hooks/incoming-webhook?token=XXXXXXXXXX';
$slackParams = array(
	'url' => $slackUrl,
	'username' => 'Chatty',
	'icon' => 'https://www.crystalvaults.com/images/bagua-square.gif',
);

$chatty = new \Manavo\Chatty\Sender(new \Manavo\Chatty\MessageHandlers\Slack($slackParams));
$chatty->send($message);
```

### HipChat

```php
$hipchatParams = array(
	'token' => '123456789123456789',
	'room_id' => 'Notifications',
	'from' => 'Chatty',
	'color' => 'random',
	'notify' => 0,
);

$chatty = new \Manavo\Chatty\Sender(new \Manavo\Chatty\MessageHandlers\Hipchat($hipchatParams));
$chatty->send($message);
```

## Custom handler

```php
class MyHandler implements \Manavo\Chatty\Interfaces\MessageHandlerInterface {

	public function handle($message)
	{
		echo $message.PHP_EOL;
	}

}

$chatty = new \Manavo\Chatty\Sender(new MyHandler());
$chatty->send($message);
```
