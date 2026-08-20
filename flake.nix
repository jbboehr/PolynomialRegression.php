{
  description = "jbboehr/PolynomialRegression.php";

  inputs = {
    nixpkgs.url = "github:nixos/nixpkgs/nixos-26.05";
    systems.url = "github:nix-systems/default";
    git-hooks = {
      url = "github:cachix/git-hooks.nix";
      inputs.nixpkgs.follows = "nixpkgs";
    };
  };

  outputs = {
    self,
    nixpkgs,
    systems,
    git-hooks,
  }: let
    forEachSystem = nixpkgs.lib.genAttrs (import systems);
  in {
    checks = forEachSystem (system: {
      pre-commit-check = git-hooks.lib.${system}.run {
        src = ./.;
        hooks = {
          actionlint.enable = true;
          alejandra.enable = true;
          alejandra.excludes = ["/vendor/"];
          markdownlint.enable = true;
          markdownlint.excludes = ["LICENSE\\.md"];
          markdownlint.settings.configuration = {
            MD013 = {
              line_length = 1488;
            };
          };
          shellcheck.enable = true;
        };
      };
    });

    devShells = forEachSystem (
      system: let
        pkgs = nixpkgs.legacyPackages.${system};
        pre-commit-check = self.checks.${system}.pre-commit-check;

        buildEnv = php:
          php.buildEnv {
            extraConfig = "memory_limit = 2G";
            extensions = {
              enabled,
              all,
            }:
              enabled ++ [all.pcov];
          };

        makeShell = php:
          pkgs.mkShell {
            packages =
              pre-commit-check.enabledPackages
              ++ [
                php
                php.packages.composer
              ];
            shellHook = ''
              ${pre-commit-check.shellHook}
              export PATH="$PWD/vendor/bin:$PATH"
            '';
          };
      in rec {
        php82 = makeShell (buildEnv pkgs.php82);
        php83 = makeShell (buildEnv pkgs.php83);
        php84 = makeShell (buildEnv pkgs.php84);
        php85 = makeShell (buildEnv pkgs.php85);
        default = php82;
      }
    );

    formatter = forEachSystem (system: nixpkgs.legacyPackages.${system}.alejandra);
  };
}
