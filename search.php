<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Search</title>
		<link rel = "stylesheet" type="text/css" href = "style/style.css" />
		<link rel="shortcut icon" href="photos/favicon.ico" />
		<link href='http://fonts.googleapis.com/css?family=Englebert' rel='stylesheet' type='text/css' />
	</head>

	<body>
		<div class = "back">
			<a href = "index.html"><img src = "photos/back.png" alt="back" title="Click to go back" height="100" width="100" /></a>
		</div><!--back-->
	
	<div class = "container" id="subpage"><!--container-->
		
		<div class="heading" id = "catalogHEADER">		
			<h1>Search</h1>
		</div><!--heading-->
		
		
		<form method = "post" action = "search.php">
			<table id = "search">
				<tr>
					<td>Search:<input type="text" name="entry" /></td>
					<td><input type = "submit" name="search" value="Search" /></td>
				</tr>
			</table>
		</form>
		
		<?php
		
			$isMATCH = true;
			
			//Check for songs.txt
			if(!isset($songs)){
				$songs = file("songs.txt");
				if (!$songs){
					print("Could not load songs.txt file\n");
					exit;
				}
			}//End Check for songs.txt
			
			if(isset($_POST["search"])) {
				$noRESULTS = false;
				$input = $_POST["entry"];
				
				$check = '/^[a-zA-Z0-9@!&#" "-248]+$/';
				if(preg_match($check, $input)){
					$rowCOUNT = count($songs);
					$searchRESULTS = array();
					$input = strtoupper($input);
					$entry = explode(' ', $input);
					$wordCOUNT = count($entry);
					
					
					//go through list
					for($i=0; $i<$rowCOUNT; $i++){
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
							$searchRESULTS[] = $songs[$i];
						}//end if match
					}//end for go through list
					
					$size = count($searchRESULTS);
					if($size==0){
						print("</br> ");
						$noRESULTS = true;
					}
				}//end if preg_match
				else{
					$noRESULTS = true;
				}//end else
			}//if search exists
			
			//print results
			if(isset($noRESULTS)){
				if($noRESULTS==true){
					print("No results were found.");
				}//end if true
				else{
					print("<p>Search Results For My Song Catalog:</p>");
			
			?>
			<div class ="data">
				<table class ="catalog" id = "search2">
						<thead>
							<tr>
							<th>Title</th>
							<th>Artist/Band</th>
							<th>Album</th>
							<th>Genre</th>
							</tr>	
						</thead>
				
			<?php
							//for cycle results	
							for($j = 0; $j<$size; $j++){
								$displayARRAY = explode("\t", $searchRESULTS[$j]);
								$count = count($displayARRAY);
								
								print("<tr>");
								//for print table
								for($l = 0; $l<$count; $l++){
									print("<td>$displayARRAY[$l]</td>");
								}//end for print table
								print("</tr>");
							}//end for cycle results
						}//end else print results
					}//end isset results
				//print("</table>");	
			?>
			
				
				</div><!--data-->

		<!--</div>container-->		

	
	</body>
</html>