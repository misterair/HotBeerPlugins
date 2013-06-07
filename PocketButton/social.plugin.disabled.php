<?php
/*
@name Pocket Button
@author Mister aiR <mister.air@gmail.com>
@licence Hot beer
@version 0.1
@description Ajoute un bouton pour sauver un article sur Pocket/Read it Later. (en attendant que Poche devienne une alternative serieuse
*/

function social_plugin_AddButton(&$event){
  $eventId = "social_".$event->getId();
  //$link = $event->getLink();
  
  $requete = 'SELECT link, title FROM '.MYSQL_PREFIX.'event WHERE id = '.$event->getId();
  $query = mysql_query($requete);
  $result = mysql_fetch_row($query);
  $link = $result[0];
  $title = $result[1];
  
  $configurationManager = new Configuration();
  $configurationManager->getAll();
  echo '<div title="Read it Later" onclick="openURL(\'https://getpocket.com/edit?url='.rawurlencode($link).'&title='.rawurlencode($title).'\');" class="social_div"><img src="./plugins/PocketButton/pocket_logo_white.png"></div>';
}

function social_plugin_update($_){
	$configurationManager = new Configuration();
	$configurationManager->getAll();

	if($_['action']=='social_update'){
		$configurationManager->put('plugin_social_pocket',$_['socialPocket']);
		$_SESSION['configuration'] = null;

		header('location: settings.php#socialBloc');
	}
}

// Ajout de la fonction au Hook situé avant l'affichage des évenements
Plugin::addJs("/js/main.js");
Plugin::addHook("event_post_top_options", "social_plugin_AddButton");   
Plugin::addHook("action_post_case", "social_plugin_update");  
?>
