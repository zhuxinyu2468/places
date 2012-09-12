<?php
/**
 * Get info on column widths from a CSV file
 * @author tyler[at]factual.com
 */

	//Set vars
	error_reporting (E_ERROR);
	$showProgress = true;
	$maxRows = 0;
	
	//assign args
	$filename = $argv[1];
	if (isset($argv[2])){$delimiter = $argv[2];}
	if (isset($argv[3])){$header = $argv[3];}
	
	//verify & structure
	if (!file_exists($filename)){
		echo "File '".$filename."' not found\n";
		exit;
	}
	$delimiter = ($delimiter) ? $delimiter : "\t";
	$header =  ($header) ? (bool)$header : true;
	if (!$fp = fopen($filename, "r")){
		echo "Could not open '".$filename."' for reading\n";
		exit;
	}
	
	//process header
	if ($header){
		$headerCols = fgetcsv($fp,0, $delimiter);
	}
	
	//get total line count for progress bar
	if ($showProgress){
		if (PHP_OS == "Linux"){
			$cmd = "wc -l \"".$filename."\"";
			$res = system($cmd);
			$res = explode(" ",$res);
			$countLines = $res[0];
		} else {
			$countLines = 0;
			$countFp = fopen($filename, "r");
			while(!feof($countFp)){
			  $line = fgets($countFp);
			  $countLines++;
			}
			fclose($countFp);
		}
		if ($header){$countLines--;}
	}
	
	//sample for arrays
	$sampleRows = 250;
	$sampleCount = 0;
	$jsonValues = array();
	$hasArrays = false;
	$fpSample = fopen($filename, "r");
	$sampleRows	= ($sampleRows > $countLines) ? $countLines : $sampleRows; 
	while ($sampleCount < $sampleRows){
		$sample = fgetcsv($fpSample,0, $delimiter);
		foreach ($sample as $index => $value){
			$json = json_decode($value,true);
			if (is_array($json)){
				$jsonValues[$index] = $index; //contains column rows that have JSON array values
			}
		}
		$sampleCount++;
	}
	if (count($jsonValues > 0)){$hasArrays = true;}
	
	//loop through rows
	$rowCount = 1;
	$colCount = 0;
	$colLength = array();   //stores length of string arrays
	$arrayLength = array(); //stores length of JSON arrays
	$dataTypes = array();
	while ($data = fgetcsv($fp,0, $delimiter)){
		//confirm column count
		$tmpCount = count($data);
		$colCount = ($tmpCount > $colCount) ? $tmpCount  : $colCount;	
		//confirm column length
		foreach ($data as $index => $value){
			$tmpLength = strlen($value);
			$colLength[$index] = ($tmpLength > $colLength[$index]) ? $tmpLength  : $colLength[$index];
			//get length of each array element
			if ($jsonValues[$index]){
				$json = json_decode($value,true);
				if (is_array($json)){
					if (!isset($arrayLength[$index])){$arrayLength[$index] = 0;}
					foreach ($json as $aIndex => $aValue){
						if (is_array($aValue)){ //array of arrays
							foreach ($aValue as $a2Value){
								$aTmpLength = strlen($a2Value);
								$arrayLength[$index] = ($aTmpLength > $arrayLength[$index]) ? $aTmpLength  : $arrayLength[$index];
							}
						} else {
							$aTmpLength = strlen($aValue);
							$arrayLength[$index] = ($aTmpLength > $arrayLength[$index]) ? $aTmpLength  : $arrayLength[$index];
						}	
					}
				}					
			}
		}
		//show progress bar
		if ($showProgress){
			show_status($rowCount, $countLines);  //comment this out to remove status
		}
		//option to truncate for testing
		$rowCount++;
		if ($maxRows === $rowCount ){
			break;
		}
	}	
	
	//output
	$arrayLabel = "";
	if ($headerCols){$labelHeader = "\tLabel";}
	if ($hasArrays){$arrayHeader = "\tArray";}
		
	echo "\n\n";
	echo "File = ".$filename."\n";
	echo "Rows = ".$rowCount."\n";
	echo "=============================\n";
	echo "Col\tStrLen".$arrayHeader.$labelHeader."\n";
	echo "-----------------------------\n";
	foreach ($colLength as $index => $value){
		if ($hasArrays){
			$arrayLabel = (isset($arrayLength[$index])) ? "\t".$arrayLength[$index] : "\t-";
		}
		
		if ($headerCols){$label = "\t".$headerCols[$index]."";}
		$colNum = $index+1;
		
		echo $colNum."\t".$value.$arrayLabel.$label."\n";
	}
	echo "=============================\n";
	
	
	/**
	 * show a status bar in the console
	 * 
	 * Copyright (c) 2010, dealnews.com, Inc.
		All rights reserved.
		
		Redistribution and use in source and binary forms, with or without
		modification, are permitted provided that the following conditions are met:
		
		 * Redistributions of source code must retain the above copyright notice,
		   this list of conditions and the following disclaimer.
		 * Redistributions in binary form must reproduce the above copyright
		   notice, this list of conditions and the following disclaimer in the
		   documentation and/or other materials provided with the distribution.
		 * Neither the name of dealnews.com, Inc. nor the names of its contributors
		   may be used to endorse or promote products derived from this software
		   without specific prior written permission.
		
		THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
		AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
		IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
		ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
		LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
		CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
		SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
		INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
		CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
		ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
		POSSIBILITY OF SUCH DAMAGE.
	 * 
	 * <code>
	 * for($x=1;$x<=100;$x++){
	 * 
	 *     show_status($x, 100);
	 * 
	 *     usleep(100000);
	 *                           
	 * }
	 * </code>
	 *
	 * @param   int     $done   how many items are completed
	 * @param   int     $total  how many items are to be done total
	 * @param   int     $size   optional size of the status bar
	 * @return  void
	 *
	 */
	function show_status($done, $total, $size = 30) {
		if ($done === 0) {
			$done = 1;
		}
		static $start_time;
		if ($done > $total)
			return; // if we go over our bound, just ignore it
		if (empty ($start_time))
			$start_time = time();
		$now = time();
		$perc = (double) ($done / $total);
		$bar = floor($perc * $size);
		$status_bar = "\r[";
		$status_bar .= str_repeat("=", $bar);
		if ($bar < $size) {
			$status_bar .= ">";
			$status_bar .= str_repeat(" ", $size - $bar);
		} else {
			$status_bar .= "=";
		}
		$disp = number_format($perc * 100, 0);
		$status_bar .= "] $disp%  $done/$total";
		if ($done === 0){$done = 1;}//avoid div zero warning
		$rate = ($now - $start_time) / $done;
		$left = $total - $done;
		$eta = round($rate * $left, 2);
		$elapsed = $now - $start_time;
		//$status_bar .= " remaining";
		//$status_bar .= " remaining: " . number_format($eta) . " sec. elapsed: " . number_format($elapsed) . " sec.";
		
		echo "$status_bar  ";
		flush();
		// when done, send a newline
		if($done == $total) {
		    echo "\n";
		}
	}
	
	
?>
