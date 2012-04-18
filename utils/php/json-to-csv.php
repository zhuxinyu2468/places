<?php

/*
 * Created on Apr 17, 2012
 * Converts Factual JSON taxonomy to CSV file with format:
 * ID [delim] LABEL [delim] BREADCRUMB
 * 
 * Abstract root node is output but not included in breadcrumbs
 * 
 */

//change these to suit
$breadCrumbDelimitor = " > "; //breadcrumb delimiter
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
	$iteration[$nodeID]['breadcrumb'] = getBreadCrumb($nodeID);
}

//order by node ID
ksort($iteration);

//render to file
$fp = fopen($outPutFile, 'a');
foreach ($iteration as $nodeID => $node) {
	fwrite($fp, $nodeID . $delim . $node['label'] . $delim . implode($breadCrumbDelimitor, $node['breadcrumb']) . "\n");
}
fclose($fp);

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
	//iterate
	foreach ($taxonomy[$nodeID]['parents'] as $parents) {
		if (isset ($iteration[$taxonomy[$nodeID]['parents'][0]])) {
			//spit back if parent has been completed previously
			$aBreadCrumb = $iteration[$taxonomy[$nodeID]['parents'][0]]['breadcrumb'];
			$aBreadCrumb[] = $taxonomy[$nodeID]['labels'][$lang];
			return $aBreadCrumb;
		} else {
			$parent = $parents[0];
			while ($parent) {
				//recurse of course
				$aBreadCrumb = getBreadCrumb($parent);
				$parent = $taxonomy[$nodeID]['parents'][0];
			}
			$aBreadCrumb[] = $taxonomy[$nodeID]['labels'][$lang]; //add label to parent breadcrumb
			return $aBreadCrumb;
		}
	}
	return array (); //catches root without parents
}

exit;
?>
