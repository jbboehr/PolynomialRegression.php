# composer2nix --composition=/dev/null --composer-env=nix/composer-env.nix --output=nix/php-packages.nix
{
  pkgs ? import <nixpkgs> { inherit system; },
  system ? builtins.currentSystem,
  noDev ? false,
  src ? ./.,
  php ? pkgs.php,
  phpPackages ? pkgs.phpPackages
}:

let
  composerEnv = import ./nix/composer-env.nix {
    inherit php phpPackages;
    inherit (pkgs) stdenv writeTextFile fetchurl unzip;
  };
  phpPackage = import ./nix/php-packages.nix {
    inherit composerEnv noDev;
    inherit (pkgs) fetchurl fetchgit fetchhg fetchsvn;
  };
in
phpPackage.override {
  inherit src;
  doCheck = true;
  postInstall = ''
      if [ -n "$doCheck" ]; then
        ./vendor/bin/phpunit || exit 1
      fi
    '';
}
