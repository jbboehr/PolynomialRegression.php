{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "doctrine/instantiator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "doctrine-instantiator-ae466f726242e637cebdd526a7d991b9433bacf1";
        src = fetchurl {
          url = https://api.github.com/repos/doctrine/instantiator/zipball/ae466f726242e637cebdd526a7d991b9433bacf1;
          sha256 = "1dzx7ql2qjkk902g02salvz0yarf1a17q514l3y6rqg53i3rmxp7";
        };
      };
    };
    "myclabs/deep-copy" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "myclabs-deep-copy-579bb7356d91f9456ccd505f24ca8b667966a0a7";
        src = fetchurl {
          url = https://api.github.com/repos/myclabs/DeepCopy/zipball/579bb7356d91f9456ccd505f24ca8b667966a0a7;
          sha256 = "0k6vc31jsmydp1dbgihvjihx7bain513y6fzrd6s9sv5r7n7dwja";
        };
      };
    };
    "phar-io/manifest" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phar-io-manifest-7761fcacf03b4d4f16e7ccb606d4879ca431fcf4";
        src = fetchurl {
          url = https://api.github.com/repos/phar-io/manifest/zipball/7761fcacf03b4d4f16e7ccb606d4879ca431fcf4;
          sha256 = "1n59a0gnk43ryl54bc37hlsi1spvi8280bq64zddxrpagyjyp15a";
        };
      };
    };
    "phar-io/version" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phar-io-version-45a2ec53a73c70ce41d55cedef9063630abaf1b6";
        src = fetchurl {
          url = https://api.github.com/repos/phar-io/version/zipball/45a2ec53a73c70ce41d55cedef9063630abaf1b6;
          sha256 = "0syr7v2b3lsdavfa22z55sdkg5awc3jlzpgn0qk0d3vf6x96hvzp";
        };
      };
    };
    "phpdocumentor/reflection-common" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-reflection-common-63a995caa1ca9e5590304cd845c15ad6d482a62a";
        src = fetchurl {
          url = https://api.github.com/repos/phpDocumentor/ReflectionCommon/zipball/63a995caa1ca9e5590304cd845c15ad6d482a62a;
          sha256 = "1fcyb675bwf9a1gjmxg0v549jjy5n16rfm0c13c5h5clz8ivfjca";
        };
      };
    };
    "phpdocumentor/reflection-docblock" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-reflection-docblock-b83ff7cfcfee7827e1e78b637a5904fe6a96698e";
        src = fetchurl {
          url = https://api.github.com/repos/phpDocumentor/ReflectionDocBlock/zipball/b83ff7cfcfee7827e1e78b637a5904fe6a96698e;
          sha256 = "0wzbcf035fyyn6awf6fzdnhbbi7w8xbdfmqn9hln381k87lsillm";
        };
      };
    };
    "phpdocumentor/type-resolver" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpdocumentor-type-resolver-2e32a6d48972b2c1976ed5d8967145b6cec4a4a9";
        src = fetchurl {
          url = https://api.github.com/repos/phpDocumentor/TypeResolver/zipball/2e32a6d48972b2c1976ed5d8967145b6cec4a4a9;
          sha256 = "17iywfpk7nf2lasb94fcbyi0fjs30fp49mqii2s8bjdwqc7gp8j4";
        };
      };
    };
    "phpspec/prophecy" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpspec-prophecy-d638ebbb58daba25a6a0dc7969e1358a0e3c6682";
        src = fetchurl {
          url = https://api.github.com/repos/phpspec/prophecy/zipball/d638ebbb58daba25a6a0dc7969e1358a0e3c6682;
          sha256 = "1aidkaiy4s8jb2p9yvbjsvrbll4c73gf34r8cmbnvqy5rgrp7iql";
        };
      };
    };
    "phpunit/php-code-coverage" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-code-coverage-f1884187926fbb755a9aaf0b3836ad3165b478bf";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/php-code-coverage/zipball/f1884187926fbb755a9aaf0b3836ad3165b478bf;
          sha256 = "1vnahnjxshyvvx1j7dsqcw1wrmwkgp5zjd2yv9bzi1lkh1lkisqm";
        };
      };
    };
    "phpunit/php-file-iterator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-file-iterator-050bedf145a257b1ff02746c31894800e5122946";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/php-file-iterator/zipball/050bedf145a257b1ff02746c31894800e5122946;
          sha256 = "0b5y1dmksnzqps694h1bhw6r6w1cqrf3vhw2k00adjdawjzaa00j";
        };
      };
    };
    "phpunit/php-text-template" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-text-template-31f8b717e51d9a2afca6c9f046f5d69fc27c8686";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/php-text-template/zipball/31f8b717e51d9a2afca6c9f046f5d69fc27c8686;
          sha256 = "1y03m38qqvsbvyakd72v4dram81dw3swyn5jpss153i5nmqr4p76";
        };
      };
    };
    "phpunit/php-timer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-timer-1038454804406b0b5f5f520358e78c1c2f71501e";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/php-timer/zipball/1038454804406b0b5f5f520358e78c1c2f71501e;
          sha256 = "0vmaca44sz6n9avd8awzk28wq5w4qnvjfl24q89611pdnkl4j8d8";
        };
      };
    };
    "phpunit/php-token-stream" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-php-token-stream-995192df77f63a59e47f025390d2d1fdf8f425ff";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/php-token-stream/zipball/995192df77f63a59e47f025390d2d1fdf8f425ff;
          sha256 = "1hl3n6kad0n4vls1sy0qgrqw3caxm2z50adi3nhzx0asdsx85nfn";
        };
      };
    };
    "phpunit/phpunit" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "phpunit-phpunit-3ee1c1fd6fc264480c25b6fb8285edefe1702dab";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/phpunit/zipball/3ee1c1fd6fc264480c25b6fb8285edefe1702dab;
          sha256 = "1j16kk57qskpna6bv5h4yc0h85wld4wllnyx6rpxdjyqcblczvw3";
        };
      };
    };
    "sebastian/code-unit-reverse-lookup" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-code-unit-reverse-lookup-4419fcdb5eabb9caa61a27c7a1db532a6b55dd18";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/code-unit-reverse-lookup/zipball/4419fcdb5eabb9caa61a27c7a1db532a6b55dd18;
          sha256 = "0n0bygv2vx1l7af8szbcbn5bpr4axrgvkzd0m348m8ckmk8akvs8";
        };
      };
    };
    "sebastian/comparator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-comparator-5de4fc177adf9bce8df98d8d141a7559d7ccf6da";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/comparator/zipball/5de4fc177adf9bce8df98d8d141a7559d7ccf6da;
          sha256 = "1kf0w51kj4whak8cdmplhj3vsvpj71bl0k3dyz197vvh83ghvl2i";
        };
      };
    };
    "sebastian/diff" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-diff-720fcc7e9b5cf384ea68d9d930d480907a0c1a29";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/diff/zipball/720fcc7e9b5cf384ea68d9d930d480907a0c1a29;
          sha256 = "0i81kz91grz5vzifw114kg6dcfh150019zid7j99j2y5w7s1fqq2";
        };
      };
    };
    "sebastian/environment" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-environment-464c90d7bdf5ad4e8a6aea15c091fec0603d4368";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/environment/zipball/464c90d7bdf5ad4e8a6aea15c091fec0603d4368;
          sha256 = "1dpd2x9yr02c4wf5icvgaw70i8bzxcmqab9plxjv00d712h73z08";
        };
      };
    };
    "sebastian/exporter" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-exporter-68609e1261d215ea5b21b7987539cbfbe156ec3e";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/exporter/zipball/68609e1261d215ea5b21b7987539cbfbe156ec3e;
          sha256 = "0i8a502xqf2ripwbr5rgw9z49z9as7fjibh7sr171q0h4yrrr02j";
        };
      };
    };
    "sebastian/global-state" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-global-state-edf8a461cf1d4005f19fb0b6b8b95a9f7fa0adc4";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/global-state/zipball/edf8a461cf1d4005f19fb0b6b8b95a9f7fa0adc4;
          sha256 = "01wba1xd5qvcx1j0vldlyixjlbyvnxnm2vx1i2y1wqaldn8d1wy2";
        };
      };
    };
    "sebastian/object-enumerator" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-object-enumerator-7cfd9e65d11ffb5af41198476395774d4c8a84c5";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/object-enumerator/zipball/7cfd9e65d11ffb5af41198476395774d4c8a84c5;
          sha256 = "00z5wzh19z1drnh52d27gflqm7dyisp96c29zyxrgsdccv1wss3m";
        };
      };
    };
    "sebastian/object-reflector" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-object-reflector-773f97c67f28de00d397be301821b06708fca0be";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/object-reflector/zipball/773f97c67f28de00d397be301821b06708fca0be;
          sha256 = "1rq5wwf7smdbbz3mj46hmjc643bbsm2b6cnnggmawyls479qmxlk";
        };
      };
    };
    "sebastian/recursion-context" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-recursion-context-5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/recursion-context/zipball/5b0cd723502bac3b006cbf3dbf7a1e3fcefe4fa8;
          sha256 = "0p4j54bxriciw67g7l8zy1wa472di0b8f8mxs4fdvm37asz2s6vd";
        };
      };
    };
    "sebastian/resource-operations" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-resource-operations-4d7a795d35b889bf80a0cc04e08d77cedfa917a9";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/resource-operations/zipball/4d7a795d35b889bf80a0cc04e08d77cedfa917a9;
          sha256 = "0prnq9hvg1bi3nkms21wl0fr0f28p0mhp5w802sqb05v9k0qnb41";
        };
      };
    };
    "sebastian/type" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-type-3aaaa15fa71d27650d62a948be022fe3b48541a3";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/type/zipball/3aaaa15fa71d27650d62a948be022fe3b48541a3;
          sha256 = "034sc9qiag074lsi990nfwzm9jnw9fysdwsd906146snqrxcqsk6";
        };
      };
    };
    "sebastian/version" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "sebastian-version-99732be0ddb3361e16ad77b68ba41efc8e979019";
        src = fetchurl {
          url = https://api.github.com/repos/sebastianbergmann/version/zipball/99732be0ddb3361e16ad77b68ba41efc8e979019;
          sha256 = "0wrw5hskz2hg5aph9r1fhnngfrcvhws1pgs0lfrwindy066z6fj7";
        };
      };
    };
    "symfony/polyfill-ctype" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "symfony-polyfill-ctype-f8f0b461be3385e56d6de3dbb5a0df24c0c275e3";
        src = fetchurl {
          url = https://api.github.com/repos/symfony/polyfill-ctype/zipball/f8f0b461be3385e56d6de3dbb5a0df24c0c275e3;
          sha256 = "056md08sxcanwp4aib9z376aq27x575n08phw3sg9mlafcyp4nii";
        };
      };
    };
    "theseer/tokenizer" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "theseer-tokenizer-11336f6f84e16a720dae9d8e6ed5019efa85a0f9";
        src = fetchurl {
          url = https://api.github.com/repos/theseer/tokenizer/zipball/11336f6f84e16a720dae9d8e6ed5019efa85a0f9;
          sha256 = "1nnym5d45fanxfp18yb0ylpwcvg3973ppzc67ana02g9w72gfspl";
        };
      };
    };
    "webmozart/assert" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "webmozart-assert-573381c0a64f155a0d9a23f4b0c797194805b925";
        src = fetchurl {
          url = https://api.github.com/repos/webmozart/assert/zipball/573381c0a64f155a0d9a23f4b0c797194805b925;
          sha256 = "0pnxl10afp5q8hnnffbnr3z0dg0ddk6x05yzj5334bvzr63msvpz";
        };
      };
    };
  };
  devPackages = {};
in
composerEnv.buildPackage {
  inherit packages devPackages noDev;
  name = "dr-que-polynomial-regression";
  src = ./.;
  executable = false;
  symlinkDependencies = false;
  meta = {
    homepage = http://www.drque.net/Projects/PolynomialRegression/;
    license = "GPL-2.0";
  };
}