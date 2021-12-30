<?php

$db = db("plotly")->where("id", get("id"))->first();
echo $db->json;
