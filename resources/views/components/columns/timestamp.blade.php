<?php
use Carbon\Carbon;

$timestamp = new Carbon($value);

echo $timestamp->diffForHumans();