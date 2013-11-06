# Factual Global Places Categories
This repo contains the master category file describing the category schema for Factual's Global Places.

## Category Overview
### Structure
Factual divides the worlds places into 460 categories (nodes in the taxonomy).  Categories are formally polyhierarchal -- a node can have more than one parent, but currently no nodes do. Nodes are identified by an Integer.  IDs are assigned sequentially and contain no semantics. 

The taxonomy has ten top-level branches:

*   Automotive
*   Community and Government
*   Healthcare
*   Landmarks
*   Retail
*   Services and Supplies
*   Social
*   Sports and Recreation
*   Transportation
*   Travel

All top-level branches are wrapped formally under a root node: ID = 1, 'Factual Places'.  There is no formal limit to the depth of the taxonomy (how many levels a branch has).  Nodes can be flagged as 'abstract', where no entities can be categorized against it; currently the root node is the only abstract node.

### Languages
The taxonomy is designed to be multi-lingual.  Currently we have the ten languages, and welcome additional, independent translations with open arms.

* (American) English
* French
* German
* Spanish
* Italian
* Japanese
* Korean
* Chinese, traditional
* Chinese, simplified
* Portuguese

## File Overview
The file contains all categories presented serially with the Category ID as the hash key.  The contents include:

*   labels: the category label with the language code as key.  The file will support IETF language tags but currently has only two-letter ISO 639-1 codes.
*   parents: array of parent IDs.  Supports multiple parents, currently no node has more than one.
*   abstract: boolean value representing whether the node is abstract (entities cannot be categorized against it). Currently only the root node is abstract.

Example:

	"220":    {
		"labels": {"en": "Accounting and Bookkeeping"},
		"parents": ["219"],
		"abstract": false
	}

## Utilities
The utils folder contains files and scripts that assist with category manipulation.  Contents:

*   <tt>old-to-new-mapping.json</tt> JSON file mapping our former categories (pre-May 2012) to the new ones documented here
*   <tt>Factual_to_MCC.tsv</tt> file mapping MCC (Merchant Category Code) to our current categories
*   <tt>Factual_to_NAICS2012.tsv</tt> file mapping NAICS (North American Industry Classification System) to our current categories
*   <tt>Factual_to_SIC87.tsv</tt> file mapping SIC (Standard Industrial Classification System) to our current categories                               

### php
A number of quick-and-dirty php scripts:

*   <tt>json-to-csv.php</tt> Convert JSON file to tab-delimited version in a select language

# License
<a rel="license" href="http://creativecommons.org/licenses/by/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 Unported License</a>.
