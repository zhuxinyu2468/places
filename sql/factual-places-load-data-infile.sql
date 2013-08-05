--load in csv
load data local infile '/home/[path-to-file]' 
into table factual_places
fields terminated by '\t'
lines terminated by '\n';
