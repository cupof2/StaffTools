<?php

namespace r\jworks;

use pocketmine\plugin\PluginBase;
use r\jworks\command\BanAll;
use r\jworks\command\Freeze;
use r\jworks\command\KickAll;
use r\jworks\command\MessageAll;
use r\jworks\command\MuteAll;
use r\jworks\command\TeleportAll;
use r\jworks\command\ViewEnderChestInventory;
use r\jworks\command\ViewInventory;
use r\jworks\command\VIewIP;
use r\jworks\command\VIewUUID;

class StaffTools extends PluginBase
{

    public $muteAll = false;

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register($this->getName(), new ViewInventory($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new ViewEnderChestInventory($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new VIewUUID($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new VIewIP($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new Freeze($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new KickAll($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new MessageAll($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new BanAll($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new MuteAll($this));
        $this->getServer()->getCommandMap()->register($this->getName(), new TeleportAll($this));

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}