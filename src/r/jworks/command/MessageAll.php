<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class MessageAll extends Command
{
    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("messageall",
            "Send a message to everyone on the server.",
            "/messageall <message>"
        );
        $this->setPermission("stafftools.command.messageall");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Wrong arguments given. " . $this->getUsage());
            return;
        }

        $message = "";

        for ($i = 0; $i < count($args); $i++) {
            $message .= $args[$i] . " ";
        }

        $this->staffTools->getServer()->broadcastMessage(TextFormat::GREEN . $sender->getName() . " to everyone: " . TextFormat::WHITE . $message);
        $sender->sendMessage(TextFormat::GREEN . "Your message has been sent.");
    }
}