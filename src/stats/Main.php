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
