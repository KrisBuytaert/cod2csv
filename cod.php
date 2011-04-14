<?php
// Bootstrap Drupal loading
require 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


$query = (db_query("
SELECT node.title, 
       node_revisions.body, 
       content_field_presenters.field_presenters_uid as field_presenters_uid, 
       content_type_time_slot.field_slot_datetime_value, 
       content_field_session_slot.field_session_slot_nid, 
       users.name 
FROM node, node_revisions, content_field_presenters, users, content_field_session_slot, content_type_time_slot 
WHERE node.nid = node_revisions.nid 
  AND node.nid = content_field_presenters.nid AND content_field_presenters.field_presenters_uid = users.uid 
  AND node.nid = content_field_session_slot.vid  
  AND content_field_session_slot.field_session_slot_nid = content_type_time_slot.vid 
  AND node.type = \"session\"
"));

print "Title,Description, Speaker,Date,Time\n<br>";

while ($talk = db_fetch_object($query))
{

 print "\"";
 print $talk->title;
 print "\"";

 print ",";
 print "\"";
 print $talk->body;
 print "\"";

 print ",";
 print "\"";
 print $talk->name;
 print "\"";

 print ",";

 list($slot_date, $slot_time) = explode(' ', $talk->field_slot_datetime_value);
 

 print "\"";
 print $slot_date;
 print "\"";

 print ",";
 print "\"";

 list($slot_hour,$slot_min) = explode(":",$slot_time);
 $slot_hour = $slot_hour+2;
 print $slot_hour;
 print ":"; 
 print $slot_min;
 print "\"";
 


 print "<br>";


}

