#!/usr/local/bin/php
<?php
if(isset($_SERVER['TripbeENV']) == false){
	echo 'TripbeENV not defined' . PHP_EOL;
	exit;
}
echo PHP_EOL . "Tripbe.com Package Manager" . PHP_EOL;
echo "==========================" . PHP_EOL;
$command = 'help';
if($argc >= 2){
	$command = $argv[1];
}
if($command == 'help'){
	$text = "
tpm help	display this info
tpm update	update libs
tpm status	show status";
	echo $text . PHP_EOL . PHP_EOL;
}else if($command == 'update'){
	command_update();
}else if($command == 'status'){
	command_status();
}

function command_status(){
	
}
function command_update(){
	global $argc, $argv;
	$update_dep = null;
	if($argc == 3){
		$update_dep = $argv[2];
	}
	$dir = $_SERVER['PWD'];
	$tpmconfig = null;
	if(is_file('tpm.conf')){
		$tpmconf = file_get_contents('tpm.conf');
		$tpmconfig = json_decode($tpmconf, true);
	}
	if($tpmconfig == null){echo "tpm.conf not found" . PHP_EOL;exit;}
	if(is_dir($dir . '/libs') == false){@mkdir($dir . '/libs');}
	if(is_dir($dir . '/libs') == false){echo 'libs not found';exit;}

	if(isset($tpmconfig['dependencies'])){
		if($update_dep != null && isset($tpmconfig['dependencies'][$update_dep]) == false){
			echo 'dependence ' . $update_dep . ' not exists.' . PHP_EOL;
		}else{
			foreach($tpmconfig['dependencies'] as $depname => $depconfig){
				if($update_dep == null || $update_dep == $depname){
					if(isset($depconfig['svn'])){
						if(isset($depconfig['isfile']) && $depconfig['isfile'] == true){
							$cmd = 'svn export ' . $depconfig['svn'] . ' ' . $dir . '/libs' . substr($depconfig['svn'], strrpos($depconfig['svn'], '/')). ' --force';
						}else{
							$cmd = 'svn export ' . $depconfig['svn'] . ' ' . $dir . '/libs/' . $depname . ' --force';
						}
						if(isset($depconfig['username'])){
							$cmd .= ' --username ' . $depconfig['username'];
						}
						if(isset($depconfig['password'])){
							$cmd .= ' --password ' . $depconfig['password'];
						}
						$cmd = str_replace('{ENV}', $_SERVER['TripbeENV'], $cmd);
						echo 'update ' . $depname;
						exec($cmd);
						echo ' done.' . PHP_EOL;
					}
				}
			}
		}
	}
}
?>