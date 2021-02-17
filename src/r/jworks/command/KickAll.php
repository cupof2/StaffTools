<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class KickAll extends Command
{
    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("kickall",
            "Kick everyone.",
            "/kickall <reason>"
        );
        $this->setPermission("stafftools.command.kickall");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if (!$this->testPermission($sender)) return;

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Wrong arguments given. " . $this->getUsage());
            return;
        }

        $reason = "";

        for ($i = 0; $i < count($args); $i++) {
            $reason .= $args[$i] . " ";
        }
        foreach ($this->staffTools->getServer()->getOnlinePlayers() as $player) {
            if ($sender->getName() != $player->getName()) {
                $player->kick(TextFormat::RED . "You have been kicked. Reason: " . $message, false);
            }
        }
        $sender->sendMessage(TextFormat::GREEN . "You've kicked everyone. Reason: " . $reason);
    }
}
