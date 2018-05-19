<?php   
    if(isset($_REQUEST['playlist'])){
        $textlist = array();
        $lines = file($_REQUEST['playlist'], FILE_IGNORE_NEW_LINES);
        $playlist = array();
        
        foreach ($lines as $line){            
            if(strpos($line, '#') == FALSE)
                if(file_exists($line))
                    $playlist[] = $line;
        }
    } else{
        $playlist = glob("Music\*.mp3");
        $textlist = glob("Music\*.m3u");
    }

    if(isset($_REQUEST['shuffle'])){
        if($_REQUEST['shuffle'] == 'on'){
            $shuffle = 'on';
            shuffle($playlist);
        }
    }
    
    $size = array();
    foreach ($playlist as $trek){
        $size[] = filesize($trek);
    }
    
    if(isset($_REQUEST['bysize'])){
        if($_REQUEST['bysize'] == 'on'){
            $bySize = 'on';
            arsort($size);
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="http://www.cs.washington.edu/education/courses/cse190m/09sp/labs/3-music/viewer.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<div id="header">

			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
		</div>
		
		
		<div id="listarea">
			<ul id="musiclist">
                            <?php foreach ($size as $key => $s){
                                $trek = $playlist[$key];
                                if($s < 1024 )
                                    $s = $s." B";
                                elseif($s < 1048575)
                                    $s = round(($s/1024), 2)." KB";
                                else
                                    $s = round(($s/1048576), 2)." MB";
                                
                                $name = basename($trek);?>
                                <li class="mp3item">
                                    <a href="<?=$trek?>">
                                            <?= $name ?></a>
					(<?= $s ?>)
				</li>
                            <?php 
                            }?>
                            
                            <?php foreach ($textlist as $textitem){
                                $name = basename($textitem);?>
                                <li class="playlistitem">
                                    <a href="index.php?playlist=<?=$textitem?>">
                                            <?= $name ?></a>
				</li>
                            <?php }?>
			</ul>
                    <a href="index.php?shuffle=<?echo (isset($shuffle)) ? '' : 'on'?>"><?echo (isset($shuffle)) ? 'Shuffle Off' : 'Shuffle On'?></a><br/>
                    <a href="index.php?bysize=<?echo (isset($bySize)) ? '' : 'on'?>"><?echo (isset($bySize)) ? 'BySize Off' : 'BySize On'?></a>
		</div>
	</body>
</html>