<?php
namespace iTzFreeHD\LB;


use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as c;

class Listeners implements Listener {

    private $plugin;

    public function __construct(LobbySystem $plugin) {
        $this->plugin = $plugin;
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        @mkdir($this->plugin->getDataFolder().'/player');
        $cfg = new Config($this->plugin->getDataFolder() . '/Items.yml', Config::YAML);
        $JoinMenu = $cfg->get('JoinMenu');

        $pcfg = new Config($this->plugin->getDataFolder().'/player/'.$event->getPlayer()->getName().'.yml',Config::YAML);
        $pcfg->set("Menu", $JoinMenu);
        $pcfg->save();

        if (empty($cfg->get($JoinMenu))) {
            $event->getPlayer()->sendMessage(c::RED.'Bitte gebe als JoinMenu ein vorhandenes Menu an');
        } else {
            $this->setItems($event->getPlayer(), $JoinMenu);
        }

    }

    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $in = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();
        $inv = $player->getInventory();

        $cfg = new Config($this->plugin->getDataFolder()."/Items.yml", Config::YAML);
        $pcfg = new Config($this->plugin->getDataFolder().'/player/'.$event->getPlayer()->getName().'.yml',Config::YAML);
        $menu = $pcfg->get('Menu');
        $fdata = $cfg->get($menu);

        //Exit [Back]
        if($in == c::RESET . c::RED . "Exit") {
            $cfg = new Config($this->plugin->getDataFolder() . '/Items.yml', Config::YAML);
            $JoinMenu = $cfg->get('JoinMenu');
            $this->setItems($player, $JoinMenu);
        }
        foreach ($fdata as $data) {
            if ($data['name'] == $in) {


                if ($in == $data['name']) {
                    $ac = explode(':', $data['action']);
                    if ($data['permissions'] === "") {

                        if ($ac[0] === 'msg') {
                            $player->sendMessage($ac[1]);
                        } elseif ($ac[0] === 'cmd'){
                            $this->plugin->getServer()->dispatchCommand($event->getPlayer(), $ac[1]);
                        } elseif ($ac[0] === 'menu') {
                            $this->setItems($player, $ac[1]);
                        } elseif ($ac[0] === 'tp') {
                            if ($ac[1] == 'spawn') {

                                $x = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
                                $y = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
                                $z = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
                                $event->getPlayer()->teleport(new Vector3($x, $y, $z), 0, 0);
                            } else {
                                $level = $this->plugin->getServer()->getLevelByName($ac[4]);
                                $block = $level->getBlock(new Vector3($ac[1], $ac[2], $ac[3]));
                                if ($block instanceof Block) {
                                    $event->getPlayer()->teleport(new Position($block->getX(), $block->getY(), $block->getZ(), $level));
                                }

                            }
                        }


                    } else {
                        if ($player->hasPermission($data['permissions'])) {
                            if ($ac[0] === 'msg') {
                                $player->sendMessage($ac[1]);
                            } elseif ($ac[0] === 'cmd'){
                                $this->plugin->getServer()->dispatchCommand($event->getPlayer(), $ac[1]);
                            } elseif ($ac[0] === 'menu') {
                                $this->setItems($player, $ac[1]);
                            } elseif ($ac[0] === 'tp') {

                                if ($ac[1] == 'spawn') {

                                    $x = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn()->getX();
                                    $y = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn()->getY();
                                    $z = $this->plugin->getServer()->getDefaultLevel()->getSafeSpawn()->getZ();
                                    $event->getPlayer()->teleport(new Vector3($x, $y, $z), 0, 0);
                                } else {
                                    $level = $this->plugin->getServer()->getLevelByName($ac[4]);
                                    $block = $level->getBlock(new Vector3($ac[1], $ac[2], $ac[3]));
                                    if ($block instanceof Block) {
                                        $event->getPlayer()->teleport(new Position($block->getX(), $block->getY(), $block->getZ(), $level));
                                    }
                                }

                            }
                        } else {
                            $player->sendMessage($cfg->get('NoPermission'));
                        }
                    }
                }
            }
        }
    }

    //no Viod
    public function onMove(PlayerMoveEvent $event) {
        $cfg = new Config($this->plugin->getDataFolder() . '/Items.yml', Config::YAML);
        $this->plugin->reloadConfig();
        if ($cfg->get('noVoid') === true) {
            $py = $event->getPlayer()->getY();

            if ($py < 0) {
                $event->getPlayer()->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn(), 0, 0);
            }
        }


    }


    //Schaden
    public function onDamage(EntityDamageEvent $event)
    {
        $cfg = new Config($this->plugin->getDataFolder() . '/Items.yml', Config::YAML);
        if ($cfg->get('noDamage') === true) {
            $event->setCancelled(true);
        }

    }

    //noDrop
    public function onDrop(PlayerDropItemEvent $event)
    {
        $cfg = new Config($this->plugin->getDataFolder() . '/Items.yml', Config::YAML);
        if ($cfg->get('noDrop') === true) {
            $event->setCancelled();
        }

    }

    //noHunger
    public function onHunger(PlayerExhaustEvent $event)
    {
        $cfg = new Config($this->plugin->getDataFolder() . '/Items.yml', Config::YAML);
        if ($cfg->get('noHunger') === true) {
            $event->setCancelled(true);
        }

    }

    //Build
    public function onPlace(BlockPlaceEvent $event)
    {
        $name = $event->getPlayer()->getName();
        if (!in_array($name, $this->plugin->buildmode)) {

            $event->setCancelled();

        }
    }


    public function onBreak(BlockBreakEvent $event)
    {
        $name = $event->getPlayer()->getName();
        if (!in_array($name, $this->plugin->buildmode)) {

            $event->setCancelled();

        }
    }
    

    //SetItem
    public function setItems(Player $player, $menu)
    {
        $inv = $player->getInventory();
        $inv->clearAll();

        $cfg = new Config($this->plugin->getDataFolder()."/Items.yml", Config::YAML);
        $sdata = $cfg->get($menu);

        foreach ($sdata as $data) {
            $id = explode(':', $data['id']);

            $item = Item::get($id[0], $id[1], $id[2]);
            $item->setCustomName($data['name']);

            $inv->setItem($data['slot'], $item);
        }
        $pcfg = new Config($this->plugin->getDataFolder().'/player/'.$player->getName().'.yml',Config::YAML);
        $pcfg->set("Menu", $menu);
        $pcfg->save();

    }
}