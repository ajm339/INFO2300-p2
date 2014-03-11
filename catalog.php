<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Catalog</title>
		<link rel = "stylesheet" type="text/css" href = "style/style.css" />
		<link rel="shortcut icon" href="photos/favicon.ico" />
		<link href='http://fonts.googleapis.com/css?family=Englebert' rel='stylesheet' type='text/css' />
	</head>

	<body>
		<div class = "back">
			<a href = "index.html"><img src = "photos/back.png" alt="back" title="Click to go back" height="100" width="100" /></a>
		</div><!--back-->
		
		<div class = "container" id="subpage">
		
			<div class="heading" id = "catalogHEADER">
				<h1>Catalog</h1>
			</div><!--heading-->
		
				<div class = "data">
		
				<?php
					
					$songsCOUNT;
					//Check for songs.txt
					if(!isset($songs)){
						$songs = file("songs.txt");
						$songsCOUNT = count($songs);
						if (!$songs){
							print("Could not load songs.txt file\n");
							exit;
						}//second if
					}//End Check for songs.txt
					if (isset($_POST["newsong"])) {
						$title = $_POST["title"];
						$artistband = $_POST["artistband"];
						$album = $_POST["album"];
						$genre = $_POST["genre"];
					}
					$update = false;
					
					//Add new song to $songs[]
					if (isset($_POST["newsong"])) {
						if(($title!="") && ($artistband!="") && ($album!="") && ($genre!="")) {
							if(checkALL()) {
								$song = $_POST["title"] . "\t" . $_POST["artistband"] . "\t" . $_POST["album"] . "\t" . $_POST["genre"] . "\n";
								$songs[] = $song;
								$update = true;
							}//end if checkALL
						}//end if check fields
						else{
							$message="You did not fill out every field.  Please try again.";
							print("<p>$message</p>");
						}//end else
					}//End Add new song
					
					
			/*Check Functions*/
					//Check All Functions
					function checkALL() {
					
						$title = $_POST["title"];
						$artistband = $_POST["artistband"];
						$album = $_POST["album"];
						$genre = $_POST["genre"];
						
						
						if ((!checkTITLE($title))||(!isset($title))){
							$message = "You did not enter the song title correctly. Please try again.";
							print("<p>$message</p>");
							return false;
						}//end Check Title if
						if (!checkARTISTBAND($artistband)){
							$message = "You did not enter the artist/band name correctly. Please try again.";
							print("<p>$message</p>");
							return false;
						}//end Check Artist Band if
						if (!checkALBUM($album)){
							$message = "You did not enter the album in correctly. Please try again.";
							print("<p>$message</p>");
							return false;
						}//end Check Album if
						if (!checkGENRE($genre)){
							$message = "You did not enter the genre in correctly. Please try again.";
							print("<p>$message</p>");
							return false;
						}//end Check Genre if
						if (checkDOUBLE($title)){
							$message = "This song is already in the catalog.  Please try again.";
							print("<p>$message</p>");
							return false;
						}//end checkDOUBLE if
						
						return true;
					}//end checkALL
			
					//Check Song Titles
					function checkTITLE($i) {
						$check = '/^[a-zA-Z0-9@!&#" "]+$/';
						$num = preg_match($check,$i);
						if($num!=0){
							return true;
						} else{
							return false;
						}
					}//end Check Song Titles
					
					//Check Artist Band
					function checkARTISTBAND($j) {
						$check = '/^[a-zA-Z0-9@!&#$" "]+$/';
						$num = preg_match($check,$j);
						if($num!=0){
							return true;
						} else{
							return false;
						}
					}//end Check Artist Band
					
					//Check Album
					function checkALBUM($k) {
						$check = '/^[a-zA-Z0-9@!&#" "-]+$/';
						$num = preg_match($check,$k);
						if($num!=0){
							return true;
						} else{
							return false;
						}
					}//end Check Album
					
					//Check Genre
					function checkGENRE($l) {
						$check = '/^[a-zA-Z248&" "]+$/';
						$num = preg_match($check,$l);
						if($num!=0){
							return true;
						} else{
							return false;
						}
					}//end Check Genre
					
					//check double
					function checkDOUBLE($d){
						$songs = file('songs.txt');
						$songsCOUNT = count($songs);
						$input = $d;
						$input = strtoupper($input);
						$entry = explode(' ', $input);
						$wordCOUNT = count($entry);
						
						
						//go through list
						for($i=0; $i<$songsCOUNT; $i++){
							$isMATCH = true;
							//go through input words
							for($k = 0; $k<$wordCOUNT; $k++){
								//if word isMATCH
								if(!preg_match("/$entry[$k]/", strtoupper($songs[$i]))){
									$isMATCH = false;
								}//if preg_match
							}//for each input word
							
							//if match true
							if($isMATCH==true){
								return true;
							}//end if match
						}//end for go through list
					}//end checkDOUBLE

			
					//Add songs back to songs.txt
					if($update) {
						$fp = fopen("songs.txt","w");
						if(!$fp){
							print("Can't open songs.txt for write.\n");
							exit;
						}
						foreach ($songs as $track){
							fputs($fp, $track);
						}
					}//End Add songs to file
					
				?>
				
					<form method="post" action="catalog.php">
						<table class = "catalog">
							<thead>
								<tr>
								<th>Title</th>
								<th>Artist/Band</th>
								<th>Album</th>
								<th>Genre</th>
								</tr>
							</thead>
						
					<?php
					
						//Write Catalog
						foreach($songs as $songindex => $track) {
							print("<tr>\n");
							$row = explode("\t", $track);
							foreach ($row as $fieldindex => $field) {
								print("<td>$field</td>\n");
							} //end foreach $row
							print("</tr>\n");
						}// end foreach $songs
					
					?>
					
							<tr>
								<td><input type="text" name="title" /></td>
								<td><input type="text" name="artistband" /></td>
								<td><input type="text" name="album" /></td>
								<td><input type="text" name="genre" /></td>
								<td><input type="submit" name="newsong" value="Add new"/></td>
							</tr>
						</table> <!--end table-->
					</form>  <!--end form-->
				
				</div><!--data-->
		
		</div><!--container-->				
	</body>
</html>