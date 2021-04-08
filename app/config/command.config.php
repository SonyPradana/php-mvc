<?Php
// regiter costume command
return array(
  [
    "cmd"       => ["-h", "--help"],
    'mode'      => "full",
    "class"     => "HelpCommand",
    "fn"        => "println",
  ],

  [
    "cmd"       => ["-v", "--version"],
    'mode'      => "full",
    "class"     => "HelpCommand",
    "fn"        => "versionCek",
  ],

  [
    "cmd"       => "--list",
    'mode'      => "full",
    "class"     => "HelpCommand",
    "fn"        => "commandList",
  ],

  [
    "cmd"       => "make",
    "mode"      => "start",
    "class"     => "MakerCommand",
    "fn"        => "switcher",
  ],

  [
    "cmd"       => "serve",
    "mode"      => "full",
    "class"     => "ServeCommand",
    "fn"        => "serve",
  ],
);
