<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class VIewIP extends Command
{

    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("viewip",
            "View someone's IP address",
            "/viewip <player>"
        );
        $this->setPermission("stafftools.command.viewip");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Wrong arguments given. " . $this->getUsage());
            return;
        }

        $target = $this->staffTools->getServer()->getPlayer($args[0]);

        if (!$target instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Player not found.");
            return;
        }

        $sender->sendMessage($target->getName() . "'s IP address: " . $target->getAddress());
    }
}