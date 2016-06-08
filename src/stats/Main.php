<?php
/*
*  Author: GamerXzavier / HyGlobalHD
*  
*  This Project Are From ArchRPG.
*  Any Contribute Are Allow As Long This Text Here.
*  
*  #Write Ur Name If U Contribute.
*  Contribute: -
*  
*  Not For Sale.
* 
*  Website: https://github.com/ArchRPG
*
*
*/
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
//By GamerXzavier
 public $players = array();
public function onEnable() {
		  @mkdir($this->getDataFolder());
@mkdir($this->getDataFolder()."PlayerDatabase/");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->getServer()->getLogger()->info("ArchStats Registered!");
		 		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this,"popup"]),15);
		}//By GamerXzavier
		public function GetDataFolderMCPE(){
			return $this->getDataFolder();
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
//By GamerXzavier
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
		//by GamerXzavier
		 public function onPlayerLogin(PlayerPreLoginEvent $event){
        $ign = $event->getPlayer()->getName();
        $player = $event->getPlayer();
        $file = ($this->getDataFolder()."PlayerDatabase/".$ign."Data.yml");  
      if(!file_exists($file)){
                $this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$ign."Data.yml", Config::YAML);
                $this->PlayerFile->set("Deaths", 0);
                $this->PlayerFile->set("Kills", 0);
                $this->PlayerFile->set("Power_Level", 0);
                $this->PlayerFile->set("Sword_Level", 0);
                $this->PlayerFile->save();
            }
            $this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$ign."Data.yml", Config::YAML);
            
        } 
        
        public function onDeath(PlayerDeathEvent $ev){
        $p=$ev->getEntity();
        $player=$ev->getEntity();
        $ign=$player->getName();
        $this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$ign."Data.yml", Config::YAML);
        $i=$this->PlayerFile->get("Deaths");
        $ii=$this->PlayerFile->get("Power_Level");
       $n = $i+1;
       $p=$ii-3;
       $this->PlayerFile->set("Deaths", $n);
       $this->PlayerFile->set("Power_Level", $p);
       $level = $player->getLevel();
                $level->addSound(new BlazeShootSound($player->getLocation()));
       $this->PlayerFile->save();
       
       $cause = $ev->getEntity()->getLastDamageCause();
	 			 if($ev->getEntity()->getLastDamageCause() instanceof EntityDamageByEntityEvent){
                   $killer = $ev->getEntity()->getLastDamageCause()->getDamager();
                $this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$killer->getName()."Data.yml", Config::YAML);
                if(!$killer->hasPermission("vip")){
                $iii=$this->PlayerFile->get("Kills");
                $nn = $iii+1;
                $this->PlayerFile->set("Kills", $nn);
                $iiii=$this->PlayerFile->get("Power_Level");
                $nnn = $iiii+3;
                $this->PlayerFile->set("Power_Level", $nnn);
                $level = $killer->getLevel();
                $level->addSound(new GhastShootSound($killer->getLocation()));
                $this->PlayerFile->save();
                $this->updatePlayer($killer);
      $this->removePlayer($player);
       
      $this->addPlayer($player);
                }else{
     $iii=$this->PlayerFile->get("Kills");
                $nn = $iii+1;
                $this->PlayerFile->set("Kills", $nn);
                $iiii=$this->PlayerFile->get("Power_Level");
                $nnn = $iiii+6;
                $this->PlayerFile->set("Power_Level", $nnn);
                $killer->sendTip("§5+6 Power Level");
                $level = $killer->getLevel();
                $level->addSound(new GhastShootSound($killer->getLocation()));
                $this->PlayerFile->save();
      $this->updatePlayer($killer);
      $this->removePlayer($player);
       
      $this->addPlayer($player);
      }
      		if($this->players[$killer->getName()]["kills"] === 5){
		Server::getInstance()->sendMessage("You On A 5 Killstreak!");
		 		if($this->PlayerFile->exists("KSREWARD")){
		 
		}else{
		 		Server::getInstance()->sendMessage("You Earned The Achivement §aFirst Killstreak!");
		 		$this->PlayerFile->set("KSREWARD");
		 		$this->PlayerFile->save();
		}
		}
		 		if($this->players[$killer->getName()]["kills"] === 10){
		Server::getInstance()->sendMessage("You On A 10 Killstreak!");
		}
		 		if($this->players[$killer->getName()]["kills"] === 15){
		Server::getInstance()->sendMessage("You On A 15 Killstreak!");
		}
		 		if($this->players[$killer->getName()]["kills"] === 20){
		Server::getInstance()->sendMessage("You On A 20 Killstreak!");
		}
		 		if($this->players[$killer->getName()]["kills"] === 25){
		Server::getInstance()->sendMessage($killer->getName()."You On A 25 Killstreak!");
		}
		 		if($this->players[$killer->getName()]["kills"] === 30){
		Server::getInstance()->sendMessage("You On A Mass Killstreak!!!");

       }
        
       }
       }    
    public function updatePlayer(Player $player) {
        
            $this->players[$player->getName()] = array(
              "kills" => $this->players[$player->getName()]["kills"] + 1  
            );
        
    }

    public function addPlayer(Player $player) {
        $this->players[$player->getName()] = array(
            "kills" => 0
        );
    }
    
    public function isPlayerSet(Player $player) {
        return in_array($player->getName(), $this->players);
    }
    
    public function removePlayer(Player $player) {
        unset($this->players[$player->getName()]);
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
        $name = $sender->getName();
        $ign = $sender->getName();

        $this->PlayerFile = new Config($this->getDataFolder()."PlayerDatabase/".$ign."Data.yml", Config::YAML);      
        if(strtolower($cmd->getName()) === 'stats'){

          if($sender->hasPermission("arch.stats")) {

            if($this->PlayerFile->get("Kills") > 0 or $this->PlayerFile->get("Deaths") > 0 or $this->PlayerFile->get("Power_Level") > 0 or $this->PlayerFile->get("Sword_Level") > 0){


           $sender->sendMessage("§l§b»§r§e".$ign." Status§0:"."\n§l§b»§r§5Power Level§8: §c".$this->PlayerFile->get("Power_Level")."\n§l§b»§r§5Sword Level§8: §c".$this->PlayerFile->get("Sword_Level")."\n§l§b»§r§5Kills§8: §c".$this->PlayerFile->get("Kills")."\n§l§b»§r§5Deaths§8: §c".$this->PlayerFile->get("Deaths")."\n§l§b»§r§5KDR§8: §c".round($this->PlayerFile->get("Kills")/$this->PlayerFile->get("Deaths"), 2));
        } else {
          $sender->sendMessage("§l§b»§r§e".$ign." Status§0:"."\n§l§b»§r§5Power Level§8: §c".$this->PlayerFile->get("Power_Level")."\n§l§b»§r§5Sword Level§8: §c".$this->PlayerFile->get("Sword_Level")."\n§l§b»§r§5Kills§8: §c".$this->PlayerFile->get("Kills")."\n§l§b»§r§5Deaths§8: §c".$this->PlayerFile->get("Deaths")."\n§l§b»§r§5KDR§8: §c".round($this->PlayerFile->get("Kills")/$this->PlayerFile->get("Deaths"), 2));
            }
          }
        }
      }
}
		
		
