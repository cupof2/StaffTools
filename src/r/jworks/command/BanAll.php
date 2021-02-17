<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class BanAll extends Command
{
    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("banall",
            "Kick everyone.",
            "/banall <reason>"
        );
        $this->setPermission("stafftools.command.banall");

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
                $this->staffTools->getServer()->dispatchCommand(new ConsoleCommandSender(), "ban " . $player . " Reason: " . $reason);
            }
        }
        $sender->sendMessage(TextFormat::GREEN . "You've banned everyone. Reason: " . $reason);
    }
}
