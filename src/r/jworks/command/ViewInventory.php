<?php


namespace r\jworks\command;


use r\jworks\libs\muqsit\invmenu\InvMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use r\jworks\StaffTools;

class ViewInventory extends Command
{

    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {

        parent::__construct("viewinventory",
            "View someone's inventory",
            "/viewinventory <player>",
            ["vi"]
        );
        $this->setPermission("stafftools.command.viewinventory");

        $this->staffTools = $staffTools;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;

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

        $inv = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $inv->setName($target->getName() . "'s inventory.");
        $inv->getInventory()->setContents($target->getInventory()->getContents());
        $inv->readonly();
        $inv->send($sender);
    }
}