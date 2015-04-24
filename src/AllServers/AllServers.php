<?php

namespace AllServers;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class AllServers extends PluginBase{
	public function onEnable(){
		$this->ft = $this->getServer()->getPluginManager()->getPlugin("FastTransfer");
		if($this->ft === null){
			$this->getLogger()->info("Plugin 'FastTransfer' not found!");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->reloadConfig();
	}
	
	public function onCommand(CommandSender $issuer, Command $cmd, $label, array $args){
		$t = $this->getConfig()->getAll();
		switch($cmd->getName()){
			case "server":
			  if($issuer->hasPermission("allservers")){
			  	if($issuer instanceof Player){
			  		if(isset($args[0])){
			  			if(isset($t[$args[0]])){
			  				$this->ft->transferPlayer($issuer, $t[$args[0]]["ip"], $t[$args[0]]["port"]);
			  				return true;
			  			}else{
			  				$issuer->sendMessage(TextFormat::RED."Server '$args[0]' not found!");
			  				return true;
			  			}
			  		}else{
			  			return false;
			  		}
			  	}else{
			  		$issuer->sendMessage("Command only works in-game!");
			  		return true;
			  	}
			  }else{
			  	$issuer->sendMessage(TextFormat::RED."You don't have permission for this!");
			  	return true;
			  }
			break;
			case "lobby":
			  if($issuer->hasPermission("allservers")){
			  	if($issuer instanceof Player){
			  			if(isset($t["lobby"])){
			  				$this->ft->transferPlayer($issuer, $t["lobby"]["ip"], $t["lobby"]["port"]);
			  				return true;
			  			}else{
			  				$issuer->sendMessage(TextFormat::RED."Lobby server not found!");
			  				return true;
			  			}
			  	}else{
			  		$issuer->sendMessage("Command only works in-game!");
			  		return true;
			  	}
			  }else{
			  	$issuer->sendMessage(TextFormat::RED."You don't have permission for this!");
			  	return true;
			  }
			break;
		}
	}
}
?>
