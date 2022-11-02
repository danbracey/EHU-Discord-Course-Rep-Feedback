<?php
include __DIR__.'/vendor/autoload.php';
//Configure Environment Variables
$strJsonFileContents = file_get_contents("config.json");
// Convert to array
$config = json_decode($strJsonFileContents, true);

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Command\Command;
use Discord\Parts\Interactions\Interaction;
use Discord\WebSockets\Event;

$discord = new Discord([
    'token' => $config['token'],
]);

$discord->on('ready', function (Discord $discord) {
    // When bot is ready, attempt to create a global slash command "/ping"
    // After the command created successfully in your bot, please remove this code
    $command = new Command($discord, [
        'name' => 'feedback',
        'description' => 'Send anonymous feedback to your course representative'
    ]);

    $discord->application->commands->save($command);
});

$discord->run();