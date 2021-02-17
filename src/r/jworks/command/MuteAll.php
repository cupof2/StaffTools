<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class MuteAll extends Command
{
    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("muteall",
            "Mute everyone on the server.",
            "/muteall"
        );
        $this->setPermission("stafftools.command.muteall");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;

        if ($this->staffTools->muteAll) {
            $this->staffTools->muteAll = false;
            $sender->sendMessage(TextFormat::GREEN . "Everyone is no longer muted.");
        } else {
            $sender->sendMessage(TextFormat::GREEN . "Everyone is now muted.");
            $this->staffTools->muteAll = true;
        }
    }
}