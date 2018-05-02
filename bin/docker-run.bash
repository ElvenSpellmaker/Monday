#!/bin/bash

cp /bindmount/{config.local.php,userlist} /data

php monday-add-guests.php
