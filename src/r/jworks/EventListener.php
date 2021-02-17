<?php


namespace r\jworks;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat;

class EventListener implements Listener
{
    private $staffTools;

    public function __construct(StaffTools $staffTools)
    {
        $this->staffTools = $staffTools;
    }

    public function onChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        if ($this->staffTools->muteAll) {
            if (!$player->hasPermission("stafftools.muteall.bypass")) {
                $event->setCancelled();
                $player->sendMessage(TextFormat::YELLOW . "Everyone is currently muted.");
            }
        }
    }
}