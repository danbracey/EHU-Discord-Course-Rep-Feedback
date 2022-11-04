# Discord Course Rep Feedback Tool

This bot is written in PHP and allows students to submit anonymous feedback to their course representatives.
The bot shows the users' course and year group when submitting feedback. The role colours for Course & Year Group are configurable from config.json  
This bot assumes that users will only ever have one Course role applied at a time. The server this bot primarily works on enforces this rule through its role application systems.

## Prerequisites
[Discord Bot Token](https://discord.com/developers/applications)

[Composer](https://getcomposer.org/)


## Deployment

To install and use, you'll need the following:

Add the Discord Application (Bot) you've created to the server you want to use the bot on. It requires Bot and Application (Slash) Commands scopes. Support for this is outside the scope of the project.

Clone this repo, and copy config.example.json to config.json, replacing the values provided with the necessary tokens/ID values.

Make sure PHP & Composer is installed, run `composer install` and run `php app.php` through the CLI. This will work with the PHP CLI only.

Once the bot is running, use the slash command /feedback and the related feedback should appear in the feedback channel (ID in config.json)
## Authors

- [@danbracey](https://github.com/danbracey)
