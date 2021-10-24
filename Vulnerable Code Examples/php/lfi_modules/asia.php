<?php

$date = new DateTime("now", new DateTimeZone('Asia/Singapore') );
echo $date->format('Y-m-d H:i:s');