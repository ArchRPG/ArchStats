<?php

namespace stats;

use pocketmine\level\sound\GhastShootSound;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\scheduler\CallbackTask;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\particle\DustParticle;

class Main extends PluginBase implements Listener
{

 public $players = array();
public function onEnable() {
		  @mkdir($this->getDataFolder());
@mkdir($this->getDataFolder()."PlayerDatabase/");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getServer()->getLogger()->info("ArchStats Registered!");
		 		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this,"popup"]),15);
		}

		public function onJoin(PlayerJoinEvent $ev){
		$ign=$ev->getPlayer()->getName();
		$p=$ev->getPlayer();
		$player=$p;
		 $this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$ign."Data.yml", Config::YAML);
		 
		 if($this->PlayerFile->get("Deaths") === 0 && $this->PlayerFile->get("Kills") === 0){
         }else{

		$this->addPlayer($p);
		}
  }

public function onHit(EntityDamageEvent $ev){


$p = $ev->getEntity();

if($ev instanceof EntityDamageByEntityEvent){
$damager = $ev->getDamager();
if($damager instanceof Player){

$this->DamagerFile = new Config($this->getDataFolder()."PlayerDatabase/".$damager->getName()."Data.yml", Config::YAML);

$this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$p->getName()."Data.yml", Config::YAML);
}
}
}
