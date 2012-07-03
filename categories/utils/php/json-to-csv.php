<?php

/*
 * Created on Apr 17, 2012
 * Converts Factual JSON taxonomy to CSV file with format:
 * ID [delim] LABEL [delim] PARENT [delim] BREADCRUMB ARRAY
 * 
 * Abstract root node is output but not included in breadcrumbs
 * 
 */

//Set error level
error_reporting (E_ERROR);

//change these to suit
$delim = "\t"; //csv file delimiter
$lang = "en"; //language to render
$taxonomyFile = "../../factual_taxonomy.json"; //filename and path
$outPutFile = "/tmp/factual_taxonomy.csv"; //output file

//Should not need to edit anything below this line
$taxonomy = json_decode(file_get_contents($taxonomyFile), true);
$iteration = array ();

//get information for each node
foreach ($taxonomy as $nodeID => $node) {
	$iteration[$nodeID]['label'] = $taxonomy[$nodeID]['labels'][$lang];
	$iteration[$nodeID]['parents'] = $taxonomy[$nodeID]['parents'];
	$iteration[$nodeID]['ancestors'] = getAncestors($nodeID);
    $iteration[$nodeID]['breadcrumb'] = getBreadCrumb($nodeID);
}
//order by node ID
ksort($iteration);

//render to file
$fp = fopen($outPutFile, 'a');
foreach ($iteration as $nodeID => $node) {
	
	$line =  $nodeID . $delim . 
	         $node['label'] . $delim . 
	         $node['parents'][0] . $delim. 
	         json_encode($node['breadcrumb']) . "\n";

	fwrite($fp, $line);
}
fclose($fp);

//get ancestors
function getAncestors($nodeID){
	global $globalParents;
	global $taxonomy;
	if ($nodeID == 1){return array();} //catches root
	if (isset ($globalParents[$nodeID])) {
		$aBreadCrumb = $globalParents[$nodeID];
		$globalParents[$nodeID] = $aBreadCrumb;
	} else {
		$iterationID = $nodeID;
		while ($parent = getParent($iterationID)){
			$aBreadCrumb[] = $parent;
			$iterationID = $parent;			
		}
		$globalParents[$nodeID] = $aBreadCrumb;
	}
	return array_reverse($aBreadCrumb);	
}


function getParent($nodeID){
	global $taxonomy;
	if (isset($taxonomy[$nodeID]['parents'][0])){
		return $taxonomy[$nodeID]['parents'][0];
	} else {
		return false;
	}
}

/**
 * returns breadcrumb for a specific node. Works only for current monohierarchy.
 * @param Factual category ID
 * @return array
 */
function getBreadCrumb($nodeID) {
	//we hateses the globals
	global $lang;
	global $taxonomy;
	global $iteration;

	if (isset($iteration[$nodeID]['ancestors'])){
		array_shift($iteration[$nodeID]['ancestors']); //removes root node
		foreach ($iteration[$nodeID]['ancestors'] as $ancestor){
			$aBreadCrumb[] = $taxonomy[$ancestor]['labels'][$lang];
		}
	}
	$aBreadCrumb[] = $taxonomy[$nodeID]['labels'][$lang];
	return $aBreadCrumb;
}

exit;
?>
