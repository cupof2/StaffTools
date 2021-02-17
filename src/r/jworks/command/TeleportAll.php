<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class TeleportAll extends Command
{
    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("teleportall",
            "Teleport everyone on the server to your position.",
            "/teleportall",
            ["tpall"]
        );
        $this->setPermission("stafftools.command.teleportall");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;
        if (!$this->testPermission($sender)) return;

        foreach ($this->staffTools->getServer()->getOnlinePlayers() as $player) {
            if ($sender->getName() != $player->getName()) {
                $player->teleport($sender);
                $player->sendMessage(TextFormat::GREEN . "You are being teleported to " . $sender->getName());
            }
        }
        $sender->sendMessage(TextFormat::GREEN . "Everyone has been teleported to your positon.");
    }
}