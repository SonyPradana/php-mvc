<?php

return array_merge(
  // help command
  HelpCommand::$command,
  // make somthink command
  MakeCommand::$command,
  // cron
  CronCommand::$command,
	// more command here
);
