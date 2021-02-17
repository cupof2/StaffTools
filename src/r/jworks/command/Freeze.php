<?php


namespace r\jworks\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class Freeze extends Command
{

    private $staffTools;
    private $players = [];
    private $frozenAll = false;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("freeze",
            "Freeze someone",
            "/freeze <player>"
        );
        $this->setPermission("stafftools.command.freeze");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;

        if (!isset($args[0])) {
            $sender->sendMessage(TextFormat::RED . "Wrong arguments given. " . $this->getUsage());
            return;
        }

        if (strtolower($args[0]) == "all") {
            if (!$this->frozenAll) {
                foreach ($this->staffTools->getServer()->getOnlinePlayers() as $onlinePlayer) {
                    if ($sender->getName() != $onlinePlayer->getName()) {
                        $onlinePlayer->setImmobile();
                    }
                }
                $this->frozenAll = true;
                $sender->sendMessage(TextFormat::GREEN . "Everyone except you is now frozen.");
                return;
            } else {
                foreach ($this->staffTools->getServer()->getOnlinePlayers() as $onlinePlayer) {
                    $onlinePlayer->setImmobile(false);
                }
                $this->frozenAll = false;
                $sender->sendMessage(TextFormat::GREEN . "Everyone is no longer frozen.");
                return;
            }
        }

        $target = $this->staffTools->getServer()->getPlayer($args[0]);

        if (!$target instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Player not found.");
            return;
        }

        if (!in_array($target->getName(), $this->players)) {
            $target->setImmobile();
            array_push($this->players, $target->getName());
            $sender->sendMessage(TextFormat::GREEN . $target->getName() . " is now immobile.");
            $target->sendMessage(TextFormat::GREEN . "You are now frozen by " . $sender->getName());
        } else {
            $target->setImmobile(false);
            unset($this->players[array_search($target->getName(), $this->players)]);
            $sender->sendMessage($target->getName() . " is no longer immobile.");
            $target->sendMessage("Your are no longer immobile.");
        }
    }
}