let
    generateTestsForPlatform = { pkgs, path, phpAttr, src }:
        pkgs.recurseIntoAttrs {
            pkg = let
                php = pkgs.${phpAttr};
            in pkgs.callPackage ../default.nix {
                inherit php src;
            };
        };
in
builtins.mapAttrs (k: _v:
  let
    path = builtins.fetchTarball {
        url = https://github.com/NixOS/nixpkgs/archive/release-20.03.tar.gz;
        name = "nixpkgs-20.03";
    };
    pkgs = import (path) { system = k; };

    gitignoreSrc = pkgs.fetchFromGitHub {
      owner = "hercules-ci";
      repo = "gitignore";
      rev = "00b237fb1813c48e20ee2021deb6f3f03843e9e4";
      sha256 = "sha256:186pvp1y5fid8mm8c7ycjzwzhv7i6s3hh33rbi05ggrs7r3as3yy";
    };
    inherit (import gitignoreSrc { inherit (pkgs) lib; }) gitignoreSource;

    src = pkgs.lib.cleanSourceWith {
      filter = (path: type: (builtins.all (x: x != baseNameOf path) [".git" "nix" ".travis.yml"]));
      src = gitignoreSource ../.;
    };
  in
  pkgs.recurseIntoAttrs {
    php72 = generateTestsForPlatform {
        inherit pkgs path src;
        phpAttr = "php72";
    };

    php73 = let
        php = pkgs.php73;
    in generateTestsForPlatform {
        inherit pkgs path src;
        phpAttr = "php73";
    };

    php74 = let
        php = pkgs.php74;
    in generateTestsForPlatform {
        inherit pkgs path src;
        phpAttr = "php74";
    };
  }
) {
  x86_64-linux = {};
  # Uncomment to test build on macOS too
  # x86_64-darwin = {};
}
