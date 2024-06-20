{
  description = "jbboehr/PolynomialRegression.php";

  inputs = {
    nixpkgs.url = "github:nixos/nixpkgs/nixos-24.05";
    flake-utils = {
      url = "github:numtide/flake-utils";
    };
    pre-commit-hooks = {
      url = "github:cachix/pre-commit-hooks.nix";
      inputs.nixpkgs.follows = "nixpkgs";
    };
    gitignore = {
      url = "github:hercules-ci/gitignore.nix";
      inputs.nixpkgs.follows = "nixpkgs";
    };
  };

  outputs = {
    self,
    nixpkgs,
    flake-utils,
    pre-commit-hooks,
    gitignore,
  }:
    flake-utils.lib.eachDefaultSystem (system: let
      buildEnv = php:
        php.buildEnv {
          extraConfig = "memory_limit = 2G";
          extensions = {
            enabled,
            all,
          }:
            enabled ++ [all.pcov];
        };
      pkgs = nixpkgs.legacyPackages.${system};
      php = buildEnv pkgs.php81;
      src = gitignore.lib.gitignoreSource ./.;

      pre-commit-check = pre-commit-hooks.lib.${system}.run {
        inherit src;
        hooks = {
          actionlint.enable = true;
          alejandra.enable = true;
          alejandra.excludes = ["\/vendor\/"];
          mdl.enable = true;
          mdl.excludes = ["LICENSE\.md"];
          shellcheck.enable = true;
        };
      };
    in rec {
      checks = {
        inherit pre-commit-check;
      };

      devShells.default = pkgs.mkShell {
        buildInputs = with pkgs; [
          actionlint
          alejandra
          mdl
          php
          php.packages.composer
          pre-commit
        ];
        shellHook = ''
          ${pre-commit-check.shellHook}
          export PATH="$PWD/vendor/bin:$PATH"
        '';
      };

      formatter = pkgs.alejandra;
    });
}
