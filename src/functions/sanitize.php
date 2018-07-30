<?php 

function escape($string){
	//CONVIRTIENDO CARACTERES MALISIOSOS EN TEXTO
	return htmlspecialchars($string,  ENT_SUBSTITUTE, "UTF-8");
}