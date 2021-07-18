<?php

return array_merge(
  // help command
  HelpCommand::$command,
  // make somthink command
  MakeCommand::$command,
  // serve
  ServeCommand::$command,
  // cron
  CronCommand::$command,
	// more command here
);
