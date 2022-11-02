<?php
include __DIR__.'/vendor/autoload.php';
//Configure Environment Variables
$strJsonFileContents = file_get_contents("config.json");
// Convert to array
$config = json_decode($strJsonFileContents, true);

use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Interactions\Interaction;
use Discord\WebSockets\Event;

$discord = new Discord([
    'token' => $config['token'],
]);

$discord->on('ready', function (Discord $discord) use ($config) {
    echo "Bot is ready!", PHP_EOL;

// Listen for messages.
    $discord->on(Event::INTERACTION_CREATE, function ( Interaction $interaction, Discord $discord) use ($config) {
        if($interaction["data"]["name"] === "feedback") {
            try {
                $embed = new \Discord\Parts\Embed\Embed($discord);
                $embed->setTitle("Student Feedback");
                $embed->setDescription("Anonymous Student Rep Feedback Service");
                $embed->setAuthor("Dan Bracey", "https://avatars.githubusercontent.com/u/16801642?v=4", "https://github.com/danbracey/ehu-discord-course-rep-feedback");
                $embed->setColor("#FFFFFF");

                //Get user's course
                $UserRoles = $interaction->member->roles;
                $Course = null;
                $YearGroup = null;
                foreach($UserRoles as $role) {
                    if($role->color === 3066993) {
                        $Course = $role->id;
                    }
                    if($role->color === 15277667) {
                        $YearGroup = $role->id;
                    }
                }

                $embed->addField([
                    'name' => 'Feedback',
                    'value' => $interaction->data->options['message']->value
                ]);

                if($Course !== null) {
                    $embed->addField([
                        'name' => "User's Course",
                        'value' => "<@&" . $Course . ">"
                    ]);
                } else {
                    $embed->addField([
                        'name' => "User's Course",
                        'value' => "No course selected by user"
                    ]);
                }

                if($YearGroup !== null) {
                    $embed->addField([
                        'name' => "User's Year Group",
                        'value' => "<@&" . $YearGroup . ">"
                    ]);
                } else {
                    $embed->addField([
                        'name' => "User's Year Group",
                        'value' => "No year-group selected / Unknown"
                    ]);
                }

                try {
                   $discord->getChannel(1037036165372596274)->sendMessage(MessageBuilder::new()
                        ->setContent('New student feedback!')
                        ->addEmbed($embed)
                    );

                    $interaction->respondWithMessage(MessageBuilder::new()
                        ->setContent(":white_check_mark: Your feedback: " . $interaction->data->options['message']->value . " has been recorded successfully!")
                        ->_setFlags(1 << 6)
                    );
                } catch (\Exception $exception) {
                    $interaction->respondWithMessage(MessageBuilder::new()
                        ->setContent(":x: There was a problem when trying to register your feedback, please speak to a Developer")
                        ->_setFlags(1 << 6)
                    );
                }


            } catch(Exception $exception) {
                $interaction->respondWithMessage(MessageBuilder::new()
                    ->setContent("Unable to send feedback, please try again later!")
                );
            }
        }
    });
});

$discord->run();