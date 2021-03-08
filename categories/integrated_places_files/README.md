# Integrated Places Category Files

This folder contains the most up-to-date versions of:
- the Integrated Places Category taxonomy.
- mappings of legacy Foursquare categories to Integrated categories.
- mappings of legacy Factual categories to Integrated categories.

These mappings are derived from the sheet [here](https://docs.google.com/spreadsheets/d/1WEa155l35R84tWfKAKakF9-MoLZ8ZjKuvP5tbLW07JE/edit#gid=221336214).

## Usage
For each legacy taxonomy to Integrated taxonomy mapping, each key is a category id from the legacy taxonomy, and each value contains the legacy category label, a single matched Integrated category, and if applicable, multiple Integrated category matches. Most categories do not have multiple integrated match categories, but every category will have a single matched Integrated category. If a legacy category has multiple Integrated category matches, then the multiple Integrated category matches are more accurate than the single matched Integrated category.

## Examples
### Legacy Factual category: has no multiple Integrated category matches
```
  "328": {
    "factual_label": "Social > Entertainment > Go Carts",
    "single_match": {
      "integrated_category_id": "10019",
      "integrated_category_label": "Arts and Entertainment > Go Kart Track",
      "is_exact": true
    }
  },
```
### Legacy Foursquare category: has no multiple Integrated category matches
```
  "4bf58dd8d48988d12f941735": {
    "foursquare_label": "Professional & Other Places > Library",
    "single_match": {
      "integrated_category_id": "12080",
      "integrated_category_label": "Community and Government > Library",
      "is_exact": true
    }
  },
```

### Legacy Factual category: has multiple Integrated category matches
```
  "150": {
    "factual_label": "Retail > Food and Beverage > Beer, Wine and Spirits",
    "single_match": {
      "integrated_category_id": "17057",
      "integrated_category_label": "Retail > Food and Beverage Retail",
      "is_exact": false
    },
    "multiple_match": [
      {
        "integrated_category_id": "17058",
        "integrated_category_label": "Retail > Food and Beverage Retail > Beer Store",
        "is_exact": false
      },
      {
        "integrated_category_id": "17080",
        "integrated_category_label": "Retail > Food and Beverage Retail > Wine Store",
        "is_exact": false
      },
      {
        "integrated_category_id": "17076",
        "integrated_category_label": "Retail > Food and Beverage Retail > Liquor Store",
        "is_exact": false
      }
    ]
  },
```

## Updating the Mappings
The mappings in this file are subject to change, and if you a mapping that you think is incorrect or would like to modify, please submit a PR and tag @ynyway! 
