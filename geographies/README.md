**[countryRegions.json](https://github.com/Factual/places/blob/master/geographies/countryRegions.json)**

This file will contain listings of all regions contained in all Factual-supported countries. It may be helpful for building autocompletion lists.

The structure is as follows:
* countries is a hash keyed by *factual_ids* of supported *countries*. The Factual Ids are the ids used within the [world-geographies](http://www.factual.com/data/t/world-geographies) table.

For each country, you will receive:
* *country* - The code that should be used when populating data in the [global places](http://www.factual.com/data/t/places) table.
* *name* - The locally used name for the country. These names will generally be in the local alphabet, not transliterated.
* *name_en* - Common English name for the country.
* *regions* - A hash of regions, keyed by *factual_ids*, for all regions contained in the appropriate country. The Factual Ids are the ids used within the [world-geographies](http://www.factual.com/data/t/world-geographies) table.

For each region, you will receive:
* *region* - The string that should be used when populating data in the [global places](http://www.factual.com/data/t/places) table.
* *name* (not always populated) - The locally used name for the country. These names will generally be in the local alphabet, not transliterated. This will often not be populated because it is either redundat with the _region_ or _name_en_ value.
* *name_en* - Common English name for the country.

NOTE: This is currently test document. Right now only USA, Canada, and Korea are populated. We'll have the rest of the our supported countries in there very, very soon.



**[addressComponentDensity.json](https://github.com/Factual/places/blob/master/geographies/addressComponentDensity.json)**

This file contains the counts of various components of postal addresses for each country supported by Factual's [global places](http://www.factual.com/data/t/places) data.

The structure is as follows:
* A hash of all two letter *country* codes, each to a list of components of the address.

The components counted are:
* *total*
* *address*
* *address_extended*
* *locality*
* *region*
* *postcode*
* *post_town*
* *admin_region*
* *po_box*
* *latitude*
* *longitude*

*Total* is the total row count for the specified country. All other attributes are defined in the [global places schema](http://www.factual.com/data/t/places/schema).
