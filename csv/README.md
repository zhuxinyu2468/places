# Working with CSV Files
Factual delivers data in tab-delimited CSV (via file) or JSON (via the API).  We do not support fixed-length outputs and cannot adhere to any maximum value lengths.  

This will rightly be problematic if you are looking to dump the information into a database.  We provide one a PHP command line tool here that reports the maximum string length of any file, and provide a link to a third-party, free product for Windows.

## PHP
Command line PHP utility to determine the maximum length of columns in a CSV file.  This is unsupported by Factual.

Command line syntax:

	PHP checkcsv.php filepath [delimeter] [header]
	
filepath = location of file
delimeter = delimiting character (default = \t)
header = has a header row with column names (default = true)

Program Output:

	File = /home/path/to/file/us_places.developer_preview.1345052880000.tab
	Rows = 2000000
	=============================
	Col	StrLen	Array	Label
	-----------------------------
	1	36	-	factual_id
	2	62	-	name
	3	31	-	address
	4	8	-	address_extended
	5	15	-	po_box
	6	17	-	locality
	7	2	-	region
	8	5	-	postcode
	9	41	-	website
	10	19	-	latitude
	11	21	-	longitude
	12	2	-	country
	13	14	-	tel
	14	14	-	fax
	15	1	-	status
	16	23	-	chain_name
	17	36	-	chain_id
	18	92	25	neighborhood
	19	5	3	category_ids
	20	91	46	category_labels
	21	32	-	email
	=============================

This script detects whether the column value is a JSON array and, if so, will also provide the max length of the array values in the Array field.

## Windows 
A free utility created by a third party, unsupported by Factual:

http://www.marcusnyberg.com/2011/08/11/analyzing-column-sizes-in-csv-files/

Command line syntax:

	CSV-checker.exe filepath delimeter

Program output:

	----------- FILE ANALYZED -----------
	Column nr | Column name | Max length
	-------------------------------------
	1 | Columname | 2
	2 | Columname | 37
	3 | Columname | 3
	4 | Columname | 44
	-------------------------------------
	Nr of columns: 4
	Nr of rows: 2701
	Nr of chars: 2117584
