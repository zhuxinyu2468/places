# Factual Global Places Categories
This repo contains the master category file describing the category schema for Factual's global Places.

## Category Overview
### Structure
Factual divides the worlds places into 440 categories (nodes in the taxonomy).  Categories are formally polyhierarchal -- a node can have more than one parent, but currently no nodes do. Nodes are identified by an Integer.  IDs are assigned sequentially and contain no semantics. 

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
The taxonomy is designed to be multi-lingual.  Currently we have (American) English only but very shortly will add French, German, Spanish, and Italian languages added.  We welcome additional independent contributions with open arms.

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

### php
A number of quick-and-dirty php scripts:

*   <tt>json-to-csv.php</tt> Convert JSON file to tab-delimited version in a select language

