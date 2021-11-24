<?php
//-- Directory Navigation with SCANDIR
//--
//-- optional placemenet
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$exclude_list = array(".", "..", "example.txt");
$i = 0;
//if (isset($_GET["dir"])) {
//  $dir_path = $_SERVER["DOCUMENT_ROOT"]."/".$_GET["dir"];
  
//}
//else {
 $dir_path = $_SERVER["DOCUMENT_ROOT"]."/webp/img"; 
//}
 
//-- until here
function dir_nav($dir_path) {
	
	$dir = isset($_GET["dir"]) ? $_GET["dir"] : '';
  global $exclude_list,$i;//, $dir_path;
  $directories = array_diff(scandir($dir_path), $exclude_list);
 
	/*$multiCurl = array();
	$result = array();
	$mh = curl_multi_init();*/
	
  //echo "<ul style='list-style:none;padding:0'>";
  foreach($directories as $entry) {	 
	
	$pathnew = $dir_path.'/'.$entry; 
	
    if(is_dir($pathnew)) {	
		$webppath =  str_replace('/img', '/w3webp/img', $pathnew);
		if (!is_dir($webppath)) {
			mkdir($webppath, 0755, true);
		}
		dir_nav($dir_path.'/'.$entry);
			
    } elseif(is_file($pathnew)) {
		$path = $pathnew;		
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$output = str_replace(array($ext,'/img'),array('webp','/w3webp/img'),$path); 
		$type = array("jpg", "jpeg", "png");
		if (in_array($ext, $type) && !file_exists($output)){
			
			$i++;
			if($i >= 100000){
				
				continue;
			} else {
					echo $i;
				echo "<li style='margin-left:5em;margin-top:5em;'>[ ] <a href='?file=".$dir.$entry."'>".$entry."</a> <span class='createbtn' style='color:#fff;padding:10px 6px; background:#00ff00;' onclick='convertintowebp(this)' data-path='".$path."' > Create webp </span> </li>";
				/*$fetchURL = 'https://www.fashionwebz.com/convertintowebp.php?image='.$path;
				$multiCurl[$i] = curl_init();
				curl_setopt($multiCurl[$i], CURLOPT_URL,$fetchURL);
				curl_setopt($multiCurl[$i], CURLOPT_HEADER,0);
				curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER,1);
				curl_multi_add_handle($mh, $multiCurl[$i]);*/
			}
			
		}
	}
	
  }
 // echo "</ul>";
  //-- separator
 /* $index=null;
do {
  curl_multi_exec($mh,$index);
} while($index > 0);

foreach($multiCurl as $k => $ch) {
  $result[$k] = curl_multi_getcontent($ch);
  print_r($result[$k]);
  curl_multi_remove_handle($mh, $ch);
}

curl_multi_close($mh);*/
}
dir_nav($dir_path);

?>
<style>
span.createbtn.disable {
    opacity: 0.5;
}
</style>

<script>
var btn = document.querySelectorAll('.createbtn');
var i = 0;
function setTimeoutChain() {
	setTimeout(() => {
	   if(btn[i] != 'undefined' && btn[i] != null && btn.length > i){	
			btn[i].click();   
			btn[i].classList.add("disable");
			btn[i].style.left = '10px';
			window.scrollTo({ top: i*118, behavior: 'smooth' });
			i++;
		}
		//setTimeoutChain();
  }, 100);
}
setTimeoutChain();
function convertintowebp(path){
	console.log(path.getAttribute('data-path'));
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "http://localhost/webp/convertintowebp.php", true);
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     //document.getElementById("demo").innerHTML = this.responseText;
	 console.log(this.responseText);
	 setTimeoutChain();
    }
  };
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
  var data = {"image":path.getAttribute("data-path")}
  //xhttp.open("POST", "https://www.fashionwebz.com/convertintowebp.php?image=" + path.getAttribute("data-path"), true);  
  xhttp.send("image=" + encodeURIComponent(path.getAttribute("data-path")));
}
</script> 